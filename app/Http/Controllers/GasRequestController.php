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
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:2.5kg,10kg',
        ]);
    
        $outlet = Outlet::find($request->outlet_id);
    
        // Check stock based on type
        $stockColumn = $request->type === '2.5kg' ? 'stock_2_5kg' : 'stock_10kg';
        $availableStock = $outlet->$stockColumn;
    
        if ($availableStock >= $request->quantity) {
            // Issue token and reduce stock
            $token = Token::create([
                'token_code' => uniqid('TOKEN_'),
                'user_id' => Auth::id(),
                'status' => 'active',
                'expires_at' => now()->addWeeks(2),
            ]);
        
            $outlet->decrement($stockColumn, $request->quantity);
        
            GasRequest::create([
                'user_id' => Auth::id(),
                'outlet_id' => $request->outlet_id,
                'type' => $request->type,
                'requested_date' => now(),
                'scheduled_date' => now()->addWeeks(2), // Default two weeks
                'status' => 'pending',
                'token_id' => $token->id,
            ]);
        
            return redirect()->route('gasrequest')->with('success', 'Gas request submitted successfully. Your token is ' . $token->token_code);
        } else {
            // Notify customer
            return redirect()->route('gasrequest')->with('error', 'Requested gas type or quantity is not available at the moment.');
        }
    }

}
