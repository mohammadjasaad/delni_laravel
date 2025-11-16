<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForceUserToCompleteProfile
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {

            $user = Auth::user();

            // ✅ مسموح فقط بالدخول إلى صفحتي "تعديل البيانات" و "تنفيذ التحديث"
            if ($user->name === "مستخدم دلني" || empty($user->name)) {

                if (
                    !$request->routeIs('dashboard.myinfo.edit') &&
                    !$request->routeIs('dashboard.myinfo.update')
                ) {
                    return redirect()->route('dashboard.myinfo.edit')
                        ->with('info', 'يرجى كتابة اسمك قبل متابعة استخدام الموقع ✅');
                }
            }
        }

        return $next($request);
    }
}
