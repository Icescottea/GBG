<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outlet;
use App\Models\Delivery;

class HeadOfficeController extends Controller
{
    public function index()
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

        // Retrieve outlets for the dropdown in the delivery form
        $outlets = Outlet::select('id', 'name')->get();

        return view('headoffice', compact('outletStatuses', 'pendingDeliveries', 'deliveries', 'outlets'));
    }

    public function storeDelivery(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'outlet_id' => 'required|exists:outlets,id',
            'scheduled_date' => 'required|date|after_or_equal:today',
        ]);

        // Create a new delivery record
        Delivery::create([
            'outlet_id' => $request->outlet_id,
            'scheduled_date' => $request->scheduled_date,
            'status' => 'pending',
        ]);

        return redirect()->route('headoffice')->with('success', 'Delivery scheduled successfully!');
    }
}
