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

        // Save the request to the database
        GasRequest::create([
            'user_id' => Auth::id(),
            'outlet_id' => $request->outlet_id,
            'type' => $request->type,
            'quantity' => $request->quantity,
            'status' => 'pending', // Mark as pending for manager review
            'requested_date' => now(),
        ]);

        return redirect()->route('gasrequest')->with('success', 'Your gas request has been submitted and is awaiting approval!');
    }


}
