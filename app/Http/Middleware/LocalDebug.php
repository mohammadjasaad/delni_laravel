<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LocalDebug
{
    public function handle(Request $request, Closure $next)
    {
        // عدّل الآيبي لآيبي جهازك
        $allowed = ['YOUR.IP.ADDR.HERE'];

        if (in_array($request->ip(), $allowed, true)) {
            config(['app.debug' => true]);
        }

        return $next($request);
    }
}
