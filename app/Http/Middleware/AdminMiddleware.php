<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // تأكد أن المستخدم مسجل دخول
        if (!Auth::check()) {
            return redirect('/login');
        }

        // تحقق من أن المستخدم يملك الدور "admin"
        if (Auth::user()->role !== 'admin') {
            abort(403, 'غير مصرح لك بالوصول إلى هذه الصفحة.');
        }

        return $next($request);
    }
}
