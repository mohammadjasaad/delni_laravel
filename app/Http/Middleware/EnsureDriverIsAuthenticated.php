<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureDriverIsAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        // ✅ التحقق من guard:driver
        if (! Auth::guard('driver')->check()) {
            return response()->json([
                'message' => 'غير مصادق (سائق)',
                'hint'    => 'يرجى تسجيل الدخول كسائق عبر /api/driver/login وإرسال التوكن في الترويسة Authorization.'
            ], 401);
        }

        return $next($request);
    }
}
