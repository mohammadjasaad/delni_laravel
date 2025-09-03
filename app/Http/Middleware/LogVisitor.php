<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Carbon\Carbon;

class LogVisitor
{
    public function handle(Request $request, Closure $next)
    {
        // نسجل فقط الصفحات العامة (مو لوحة المشرف أو المستخدم)
        if (! $request->is('admin/*') && ! $request->is('dashboard/*')) {
            Visitor::create([
                'ip'         => $request->ip(),
                'page'       => $request->path(),
                'user_agent' => $request->userAgent(),
                'visited_at' => Carbon::now(),
            ]);
        }

        return $next($request);
    }
}
