<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDriver
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'driver') {
            return $next($request);
        }

        abort(403, '🚫 ليس لديك صلاحية دخول لوحة السائق.');
    }
}
