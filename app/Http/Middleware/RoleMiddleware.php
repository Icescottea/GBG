<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // Check if the user is authenticated
        if (!Auth::check() && !$request->routeIs('home', 'about', 'contact')) {
            return redirect()->route('login'); // Allow guests to stay on home, about, and contact
        }
        
        // Check if the authenticated user has the required role
        if (Auth::user()->role !== $role) {
            return abort(403, 'Unauthorized access'); // Deny access if role does not match
        }

        return $next($request); // Allow the request to proceed
    }
}
