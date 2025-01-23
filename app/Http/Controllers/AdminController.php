<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function assignRole(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:userss,email',
            'role' => 'required|in:customer,outlet_manager,head_office_staff,admin',
        ]);

        $user = User::where('email', $request->email)->first();
        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('success', 'Role assigned successfully!');
    }
}
