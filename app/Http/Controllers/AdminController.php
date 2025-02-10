<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function index(Request $request)
    {
        $outlets = Outlet::all();
        $selectedUser = null;

        if ($request->has('email')) {
            $selectedUser = User::where('email', $request->email)->first();
        }

        return view('admindashboard', compact('outlets', 'selectedUser'));
    }
    
    public function assignRole(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:userss,email',
            'role' => 'required|string|in:admin,head_office_staff,outlet_manager,business,customer',
            'outlet_id' => 'nullable|exists:outlet,id',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'User not found.']);
        }

        // Assign Role
        $user->role = $request->role;

        // Handle outlet manager assignment
        if ($request->role === 'outlet_manager' && $request->outlet_id) {
            $outlet = Outlet::find($request->outlet_id);
            if ($outlet) {
                $outlet->manager_email = $user->email;
                $outlet->save();
            }
            $user->outlet_id = $request->outlet_id;
        } else {
            $user->outlet_id = null;
        }

        // Handle Business Verification
        if ($request->role === 'business') {
            $user->is_verified = $request->has('business_verified') ? 1 : 0;
        }

        $user->save();

        return redirect()->route('admindashboard')->with('success', 'Role assigned successfully!');
    }

}
