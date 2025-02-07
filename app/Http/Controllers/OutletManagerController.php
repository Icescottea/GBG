<?php

namespace App\Http\Controllers;

use App\Models\GasRequest;
use App\Models\Outlet;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OutletManagerController extends Controller
{
    public function index()
    {
        // Get the outlet the manager is assigned to
        $outlet = Outlet::where('manager_email', Auth::user()->email)->firstOrFail();

        // Get pending gas requests for this outlet
        $gasRequests = GasRequest::with('user', 'outlet')
            ->where('outlet_id', $outlet->id)
            ->where('status', 'pending')
            ->get();

        // Get stock levels
        $stock = Outlet::select('stock_5kg', 'stock_12kg', 'pending_stock_5kg', 'pending_stock_12kg')
            ->where('id', $outlet->id)
            ->first();

        // Get upcoming deliveries for this outlet
        $upcomingDeliveries = Delivery::where('outlet_id', $outlet->id)
            ->where('scheduled_date', '>=', now())
            ->get(['id','scheduled_date', 'qty_5kg_stock', 'qty_12kg_stock', 'status']);

        // Get issued tokens for this outlet
        $issuedTokens = \DB::table('tokens')
        ->join('gas_requests', 'tokens.id', '=', 'gas_requests.token_id')
        ->join('userss', 'gas_requests.user_id', '=', 'userss.id')
        ->where('gas_requests.outlet_id', $outlet->id)
        ->where('tokens.status', 'active')
        ->select('tokens.*','userss.name as user_name', 'gas_requests.type', 'gas_requests.quantity', 'gas_requests.issued_from')
        ->get();

        $tokenHistory = \DB::table('tokens')
        ->join('gas_requests', 'tokens.id', '=', 'gas_requests.token_id')
        ->join('userss', 'gas_requests.user_id', '=', 'userss.id')
        ->where('gas_requests.outlet_id', $outlet->id)
        ->whereIn('tokens.status', ['completed', 'failed'])
        ->select('tokens.*', 'userss.name as user_name', 'gas_requests.type', 'gas_requests.quantity')
        ->get();

        return view('outletmanager', compact('outlet', 'gasRequests', 'stock', 'upcomingDeliveries', 'issuedTokens', 'tokenHistory'));
    }

    public function approveRequest($id)
    {
        $request = GasRequest::findOrFail($id);
        $outlet = Outlet::findOrFail($request->outlet_id);

        // Ensure the request belongs to the authenticated outlet manager
        if ($request->outlet_id !== Auth::user()->outlet_id) {
            return redirect()->back()->withErrors(['error' => 'Unauthorized action.']);
        }

        // Check if the user already has an active token
        if (\DB::table('tokens')->where('user_id', $request->user_id)->where('status', 'active')->exists()) {
            return redirect()->back()->withErrors(['error' => 'An active token already exists for this user.']);
        }

        $issuedFrom = null;

        // Check stock levels and deduct stock accordingly
        if ($request->type === '5kg') {
            if ($outlet->stock_5kg >= $request->quantity) {
                // Deduct from actual stock
                $outlet->stock_5kg -= $request->quantity;
                $issuedFrom = 'stock';
            } elseif ($outlet->pending_stock_5kg >= $request->quantity) {
                // Deduct from pending stock
                $outlet->pending_stock_5kg -= $request->quantity;
                $issuedFrom = 'pending_stock';
            } else {
                return redirect()->back()->with('error', 'Insufficient stock to approve this request.');
            }
        } elseif ($request->type === '12kg') {
            if ($outlet->stock_12kg >= $request->quantity) {
                // Deduct from actual stock
                $outlet->stock_12kg -= $request->quantity;
                $issuedFrom = 'stock';
            } elseif ($outlet->pending_stock_12kg >= $request->quantity) {
                // Deduct from pending stock
                $outlet->pending_stock_12kg -= $request->quantity;
                $issuedFrom = 'pending_stock';
            } else {
                return redirect()->back()->with('error', 'Insufficient stock to approve this request.');
            }
        }

        $outlet->save();
        $outlet->updateStatus();

        // Create a new token in the tokens table
        $token = \DB::table('tokens')->insertGetId([
            'token_code' => uniqid('TOKEN-'), // Generate a unique token code
            'user_id' => $request->user_id,
            'status' => 'active', // Set status to active
            'expires_at' => now()->addWeeks(2), // Set expiration date
            'created_at' => now(),
        ]);

        // Update the gas request with the generated token ID and issued_from
        $request->token_id = $token;
        $request->status = 'confirmed'; // Update status to confirmed
        $request->scheduled_date = now()->addDay(); // Set the delivery schedule
        $request->issued_from = $issuedFrom; // Update issued_from based on stock type
        $request->save();

        return redirect()->back()->with('success', 'Request approved, and token issued.');
    }


    public function receiveDelivery($id)
    {
        $delivery = Delivery::findOrFail($id);

        if ($delivery->status === 'completed') {
            return redirect()->back()->with('error', 'This delivery has already been received.');
        }

        $delivery->status = 'completed';
        $delivery->delivered_date = now();
        $delivery->save();

        $outlet = Outlet::find($delivery->outlet_id);
        $outlet->stock_5kg += $delivery->qty_5kg_stock;
        $outlet->stock_12kg += $delivery->qty_12kg_stock;

        // Reset pending stock
        $outlet->pending_stock_5kg = 0;
        $outlet->pending_stock_12kg = 0;

        $outlet->save();
        $outlet->updateStatus();

        return redirect()->back()->with('success', 'Delivery received and stock updated successfully.');
    }

    public function extendToken(Request $request, $id)
    {
        // Find the token by ID
        $token = \DB::table('tokens')->where('id', $id)->first();

        // Ensure the token exists
        if (!$token) {
            return redirect()->back()->with('error', 'Token not found.');
        }

        // Check if the token is associated with the current outlet and issued from pending stock
        $gasRequest = GasRequest::where('token_id', $id)
            ->where('outlet_id', Auth::user()->outlet_id)
            ->where('issued_from', 'pending_stock')
            ->first();

        if (!$gasRequest) {
            return redirect()->back()->with('error', 'Token cannot be extended.');
        }

        // Extend the token's expiration date by 2 week
        $newExpiry = now()->addWeek(2);

        \DB::table('tokens')->where('id', $id)->update([
            'expires_at' => $newExpiry,
        ]);

        return redirect()->back()->with('success', 'Token extended successfully! New expiration date: ' . $newExpiry->toDateString());
    }

    public function completeToken($id)
    {
        $token = \DB::table('tokens')->where('id', $id)->first();

        if (!$token) {
            return redirect()->back()->with('error', 'Token not found.');
        }

        \DB::table('tokens')->where('id', $id)->update([
            'status' => 'completed',
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Token marked as completed.');
    }

    public function failToken($id)
    {
        $token = \DB::table('tokens')->where('id', $id)->first();

        if (!$token) {
            return redirect()->back()->with('error', 'Token not found.');
        }

        \DB::table('tokens')->where('id', $id)->update([
            'status' => 'failed',
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Token marked as failed.');
    }

}
