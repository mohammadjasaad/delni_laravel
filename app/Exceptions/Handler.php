<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * ✅ الرد على unauthenticated API requests برسالة JSON مرتبة حسب الـ guard
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->is('api/*')) {
            $guards = $exception->guards();
            $guard = $guards[0] ?? null;

            $message = 'غير مصادق';
            $hint = 'يرجى تسجيل الدخول أولاً باستخدام التوكن الصحيح.';

            if ($guard === 'driver') {
                $message = 'غير مصادق (سائق)';
                $hint = 'يرجى تسجيل الدخول كسائق عبر /api/driver/login وإرسال التوكن في الترويسة Authorization.';
            } elseif ($guard === 'web' || $guard === 'sanctum') {
                $message = 'غير مصادق (مستخدم)';
                $hint = 'يرجى تسجيل الدخول كمستخدم عبر /api/login وإرسال التوكن الصحيح.';
            }

            return response()->json([
                'message' => $message,
                'hint'    => $hint
            ], 401);
        }

        return redirect()->guest(route('login'));
    }
}
