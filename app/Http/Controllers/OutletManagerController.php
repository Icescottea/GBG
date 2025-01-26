<?php

namespace App\Http\Controllers;

use App\Models\GasRequest;
use App\Models\Outlet;
use App\Models\Delivery;
use Illuminate\Support\Facades\Auth;

class OutletManagerController extends Controller
{
    public function index()
    {
        // Get the outlet the manager is assigned to
        $outlet = Outlet::where('manager_email', Auth::user()->email)->firstOrFail();

        // Get pending gas requests for this outlet
        $gasRequests = GasRequest::with('outlet')
            ->where('outlet_id', $outlet->id)
            ->where('status', 'pending')
            ->get();

        // Get stock levels
        $stock = Outlet::select('stock_5kg', 'stock_12kg')
            ->where('id', $outlet->id)
            ->first();

        // Get upcoming deliveries for this outlet
        $upcomingDeliveries = Delivery::where('outlet_id', $outlet->id)
            ->where('scheduled_date', '>=', now())
            ->get();

        return view('outletmanager', compact('outlet', 'gasRequests', 'stock', 'upcomingDeliveries'));
    }

    public function approveRequest($id)
    {
        $request = GasRequest::findOrFail($id);

        // Ensure the request belongs to the authenticated outlet manager
        if ($request->outlet_id !== Auth::user()->outlet_id) {
            return redirect()->back()->withErrors(['error' => 'Unauthorized action.']);
        }

        // Create a new token in the tokens table
        $token = \DB::table('tokens')->insertGetId([
            'token_code' => uniqid('TOKEN-'), // Generate a unique token code
            'user_id' => $request->user_id,
            'status' => 'active', // Corrected to use a valid enum value
            'expires_at' => now()->addWeeks(2), // Set expiration date
            'created_at' => now(),
        ]);

        // Update the gas request with the generated token ID
        $request->token_id = $token;
        $request->status = 'confirmed'; // Update status to confirmed
        $request->scheduled_date = now()->addDay(); // Set the delivery schedule
        $request->save();

        return redirect()->back()->with('success', 'Request approved, and token issued.');
    }


}
