<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserLastSeen
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {

            // المستخدم يعتبر "متصل الآن" لمدة 5 دقائق
            Cache::put('user-is-online-' . Auth::id(), true, now()->addMinutes(5));

            // تحديث آخر ظهور
            Auth::user()->update([
                'last_seen' => now()
            ]);
        }

        return $next($request);
    }
}
