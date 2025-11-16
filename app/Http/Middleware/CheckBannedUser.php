<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBannedUser
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isBanned()) {

            Auth::logout();

            return redirect()->route('login')
                ->with('error', '🚫 حسابك محظور من استخدام الموقع. يرجى التواصل مع الدعم.');
        }

        return $next($request);
    }
}

