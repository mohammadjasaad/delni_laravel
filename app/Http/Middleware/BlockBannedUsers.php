<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class BlockBannedUsers
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->banned_at) {
            Auth::logout();
            return redirect()->route('banned.message');
        }

        return $next($request);
    }
}

