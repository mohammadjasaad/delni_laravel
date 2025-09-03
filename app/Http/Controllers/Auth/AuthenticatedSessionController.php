<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * عرض صفحة تسجيل الدخول
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * تنفيذ عملية تسجيل الدخول
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // ✅ إعادة التوجيه حسب الدور
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('dashboard.index');
    }

    /**
     * تنفيذ عملية تسجيل الخروج
     */
    public function destroy(Request $request): RedirectResponse
    {
        // ✅ تسجيل الخروج
        Auth::guard('web')->logout();

        // ✅ إبطال الجلسة
        $request->session()->invalidate();

        // ✅ إعادة إنشاء التوكين
        $request->session()->regenerateToken();

        // ✅ تحويل المستخدم إلى صفحة "تم تسجيل الخروج"
        return redirect()->route('logged-out');
    }
}
