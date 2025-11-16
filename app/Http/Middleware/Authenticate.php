<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * If the user is not authenticated, redirect them to login.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    /**
     * هنا نتحقق إذا المستخدم محظور بعد تسجيل الدخول
     */
    public function handle($request, \Closure $next, ...$guards)
    {
        // أكمل التحقق الطبيعي
        $response = parent::handle($request, $next, ...$guards);

        // ✅ إذا المستخدم محظور → نطرده
        if (auth()->check() && auth()->user()->banned_at) {
            auth()->logout();
            return redirect()->route('banned.message');
        }

        return $response;
    }
}
