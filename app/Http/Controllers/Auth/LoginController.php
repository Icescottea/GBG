<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Override the redirectTo method to redirect based on user roles.
     */
    protected function redirectTo()
    {
        $user = Auth::user();

        // Redirect based on the role
        switch ($user->role) {
            case 'admin':
                return '/admindashboard';
            case 'outlet_manager':
                return '/outletmanager';
            case 'head_office_staff':
                return '/headoffice';
            default:
                return '/home'; // Default for customers
        }
    }

    /**
     * Handle the login attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Login successful
            return redirect()->intended($this->redirectTo());
        }

        // Login failed
        return redirect()->back()->withErrors(['email' => 'These credentials do not match our records.']);
    }
}
