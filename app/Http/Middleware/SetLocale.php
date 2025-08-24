<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * اضبط لغة التطبيق من الجلسة. افتراضي: ar
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale', config('app.locale', 'ar'));
        if (! in_array($locale, ['ar', 'en'], true)) {
            $locale = 'ar';
        }

        // ✔️ اضبط لغة Laravel (الصحيحة)
        app()->setLocale($locale);

        // (اختياري) اضبط PHP locale لعرض التواريخ بصيغة محلية
        try {
            if ($locale === 'ar') {
                @\setlocale(LC_TIME, 'ar_SA.UTF-8', 'ar_EG.UTF-8', 'ar.UTF-8', 'ar');
            } else {
                @\setlocale(LC_TIME, 'en_US.UTF-8', 'en_GB.UTF-8', 'C');
            }
        } catch (\Throwable $e) {
            // تجاهل أي خطأ هنا
        }

        return $next($request);
    }
}
