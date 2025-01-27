<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Token;

class TokenController extends Controller
{
    public function index()
    {
        // Retrieve active tokens for the authenticated user
        $tokens = Token::where('user_id', Auth::id())
            ->where('status', 'active')
            ->get()
            ->map(function ($token) {
                // Calculate days before expiry
                $token->days_before_expiry = now()->diffInDays($token->expires_at, false);
                return $token;
            });

            return view('tokens', compact('tokens'));
    }

}
