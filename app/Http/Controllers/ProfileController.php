<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('profile');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:userss,email,' . Auth::id(),
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);
        
        $user = User::findOrFail(Auth::user()->id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');

        if ($request->filled('current_password')) {
            if (Hash::check($request->input('current_password'), $user->password)) {
                $user->password = Hash::make($request->input('new_password'));
            } else {
                return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
        }

        $user->save();

        return redirect()->route('profile')->withSuccess('Profile updated successfully.');
    }

    public function deleteAccount(Request $request)
    {
        $user = Auth::user();
    
        // Optionally: Delete related data if needed (like gas requests, tokens, etc.)
    
        Auth::logout(); // Log the user out before deleting the account
    
        $user->delete();
    
        return redirect('/')->with('success', 'Your account has been deleted successfully.');
    }

}
