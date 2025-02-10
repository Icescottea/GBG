<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\GasRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GasRequestController extends Controller
{
    public function __construct()
    {
       // $this->middleware('auth'); // Ensure users are logged in
    }

    /**
     * Display the Gas Request page.
     */
    public function index()
    {
        // Fetch all outlets
        $outlets = Outlet::all(); // Fetch all outlets
        return view('gasrequest', compact('outlets'));
    }

    /**
     * Handle gas request submission.
     */
    public function store(Request $request)
    {
                
        $request->validate([
            'outlet_id' => 'required|exists:outlet,id',
            'type' => 'required|in:5kg,12kg',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $outlet = Outlet::find($request->outlet_id);

        if (!$outlet) {
            return redirect()->back()->withErrors(['error' => 'Invalid outlet selected.']);
        }
    
        // **Strictly prevent requests when stock & pending stock are zero**
        if (
            ($request->type === '5kg' && $outlet->stock_5kg == 0 && $outlet->pending_stock_5kg == 0) ||
            ($request->type === '12kg' && $outlet->stock_12kg == 0 && $outlet->pending_stock_12kg == 0)
        ) {
            return redirect()->back()->withErrors(['error' => 'No stock available for the selected type. Please try again later.']);
        }


        // Check if the user has a pending request
        $hasPendingRequest = GasRequest::where('user_id', Auth::id())
        ->where('status', 'pending')
        ->exists();

        // Check if the user has an active token (but ignore completed/failed tokens)
        $hasActiveToken = \App\Models\Token::where('user_id', Auth::id())
        ->where('status', 'active') // Only block active tokens
        ->exists();

        if ($hasPendingRequest || $hasActiveToken) {
        return redirect()->back()->withErrors([
            'error' => 'You already have an ongoing transaction (a pending request or an active token). 
            Please complete it before making a new request.',
        ]);
        }

        // Save the request to the database
        GasRequest::create([
            'user_id' => Auth::id(),
            'outlet_id' => $request->outlet_id,
            'type' => $request->type,
            'quantity' => $request->quantity,
            'status' => 'pending', // Mark as pending for manager review
            'requested_date' => now(),
        ]);

        return redirect()->route('gasrequest')->with('success', 
        'Your gas request has been submitted and is awaiting approval!');
    }
}
