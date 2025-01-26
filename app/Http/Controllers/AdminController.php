<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function index()
    {
        $outlets = \App\Models\Outlet::all(); // Fetch all outlets
        return view('admindashboard', compact('outlets'));
    }

    
    public function assignRole(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:userss,email',
            'role' => 'required|string|in:admin,head_office_staff,outlet_manager,customer',
            'outlet_id' => 'nullable|exists:outlet,id', // Outlet ID validation
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user) {
            return redirect()->back()->withErrors(['email' => 'User not found.']);
        }

        // Assign the role
        $user->role = $request->role;

        // Handle outlet assignment for outlet manager
        if ($request->role === 'outlet_manager' && $request->outlet_id) {
            // Update manager_email in the outlet table
            $outlet = Outlet::find($request->outlet_id);
            $outlet->manager_email = $user->email;
            $outlet->save();

            $user->outlet_id = $request->outlet_id;         
        } else {
            $user->outlet_id = null; // Reset outlet_id for other roles
        }

        $user->save();

        return redirect()->back()->with('success', 'Role assigned successfully!');
    }
}
