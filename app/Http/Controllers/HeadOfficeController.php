<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outlet;
use App\Models\Delivery;
use App\Models\GasRequest;
use App\Notifications\ScheduledDeliveryNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Models\Token;
use App\Models\User;
use Carbon\Carbon;

class HeadOfficeController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve outlet statuses and map 0/1 to 'Active'/'Inactive'
        $outletStatuses = Outlet::select('id', 'name', 'status', 'stock_5kg', 'stock_12kg')
            ->get()
            ->map(function ($outlet) {
                $outlet->status = $outlet->status == 0 ? 'Active' : 'Inactive';
                return $outlet;
            });

        // Retrieve count of pending deliveries
        $pendingDeliveries = Delivery::where('status', 'pending')->count();

        // Retrieve all deliveries for the dispatch office view
        $deliveries = Delivery::with('outlet:id,name')->orderBy('scheduled_date', 'asc')->get();

        // Fetch all outlets for dropdown
        $outlets = Outlet::all();

        // Default outlet selection (first outlet if none selected)
        $selectedOutletId = $request->query('outlet_id') ?? ($outlets->first()->id ?? null);

        if (!$selectedOutletId) {
            return view('headoffice', compact('outlets', 'selectedOutletId'))->withErrors(['error' => 'No outlets available.']);
        }    

        // Fetch Monthly Requests for Selected Outlet
        $monthlyRequests = \DB::table('gas_requests')
            ->selectRaw('MONTH(requested_date) as month, COUNT(*) as count')
            ->where('outlet_id', $selectedOutletId)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($data) {
                $data->month = Carbon::create()->month($data->month)->format('F'); // Convert month number to name
                return $data;
            });

        // Fetch Completed Tokens for Selected Outlet
        $completedTokens = \DB::table('tokens')
            ->join('gas_requests', 'tokens.id', '=', 'gas_requests.token_id')
            ->where('tokens.status', 'completed')
            ->where('gas_requests.outlet_id', $selectedOutletId)
            ->count();

        // Fetch Sold Cylinders (From Completed Tokens)
        $soldCylinders = \DB::table('tokens')
            ->join('gas_requests', 'tokens.id', '=', 'gas_requests.token_id')
            ->where('tokens.status', 'completed')
            ->where('gas_requests.outlet_id', $selectedOutletId)
            ->selectRaw("
                SUM(CASE WHEN gas_requests.type = '5kg' THEN gas_requests.quantity ELSE 0 END) as total_5kg,
                SUM(CASE WHEN gas_requests.type = '12kg' THEN gas_requests.quantity ELSE 0 END) as total_12kg ")
            ->first();

        return view('headoffice', compact('outletStatuses', 'pendingDeliveries', 'deliveries', 'outlets', 'selectedOutletId', 
        'monthlyRequests','completedTokens', 'soldCylinders'));
    }

    public function storeDelivery(Request $request)
    {
        $request->validate([
            'outlet_id' => 'required|exists:outlet,id',
            'scheduled_date' => 'required|date|after_or_equal:today',
            'qty_5kg_stock' => 'required|integer|min:0',
            'qty_12kg_stock' => 'required|integer|min:0',
        ]);

        $delivery = Delivery::create([
            'outlet_id' => $request->outlet_id,
            'scheduled_date' => $request->scheduled_date,
            'qty_5kg_stock' => $request->qty_5kg_stock,
            'qty_12kg_stock' => $request->qty_12kg_stock,
            'status' => 'pending',
        ]);

        // Fetch all users with active tokens related to the selected outlet
        $activeTokenUsers = User::whereHas('tokens', function ($query) use ($request) {
            $query->where('status', 'active')
                  ->whereHas('gasRequest', function ($subQuery) use ($request) {
                      $subQuery->where('outlet_id', $request->outlet_id);
                  });
        })->get();
        
        // Add logging right here to verify users are found
        if ($activeTokenUsers->isEmpty()) {
            \Log::error("No active token holders found for outlet ID: " . $request->outlet_id);
        } else {
            foreach ($activeTokenUsers as $user) {
                \Log::info("Sending notification email to: " . $user->email);
            }
        }

        // Send email notifications to active token holders
        Notification::send($activeTokenUsers, new ScheduledDeliveryNotification($delivery));

        // Update outlet pending stock
        $outlet = Outlet::find($request->outlet_id);
        $outlet->pending_stock_5kg += $request->qty_5kg_stock;
        $outlet->pending_stock_12kg += $request->qty_12kg_stock;
        $outlet->save();

        return redirect()->route('headoffice')->with('success', 'Delivery scheduled successfully, and notifications sent to token holders.');
    }

}
