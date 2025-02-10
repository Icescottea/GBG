<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    //Get a validator for an incoming registration request.
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'id' => ['required', 'string', 'max:255', 'unique:userss'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:userss'],
            'phone' => ['required', 'string', 'max:15', 'unique:userss'],
            'address' => ['required', 'string', 'max:500'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:customer,business'], // Ensure only valid roles
            'certificate' => ['nullable', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
        ]);
    }

    //Create a new user instance after a valid registration.
    protected function create(array $data)
    {
        $request = request();

        Log::info("Received registration data: ", $data);

        // Handle certificate upload for business users
        $certificatePath = null;
        if ($request->role === 'business' && $request->hasFile('certificate')) {
            $certificatePath = $request->file('certificate')->store('certificates', 'public');
            Log::info("Certificate uploaded: " . $certificatePath);
        }

        // Create the user
        $user = User::create([
            'id' => $data['id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'certificate_path' => $certificatePath,
            'status' => $data['role'] === 'business' ? 'pending' : 'active', // Business users require admin approval
        ]);

        if (!$user) {
            Log::error("User creation FAILED for email: " . $data['email']);
            return redirect()->back()->withErrors(['registration' => 'User registration failed.']);
        }

        Log::info("User created successfully: " . json_encode($user));

        return $user;
    }

    //Redirect users after registration.
    protected function registered(Request $request, $user)
    {
        if ($user->role === 'business') {
            return redirect()->route('login')->with('success', 'Business account registered. Await admin approval.');
        }

        Auth::login($user); // Auto-login for regular customers
        return redirect()->route('home')->with('success', 'Registration completed successfully! Welcome, ' . $user->name . '.');
    }
}
