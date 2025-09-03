<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // ✅ عرض إشعارات المشرف
    public function notifications()
    {
        $admin = Auth::user();

        // فقط لو كان المشرف
        if ($admin->role !== 'admin') {
            abort(403, __('messages.access_denied'));
        }

        // جلب الإشعارات (صفحة 20 إشعار لكل صفحة)
        $notifications = $admin->notifications()->latest()->paginate(20);

        return view('admin.notifications', compact('notifications'));
    }
}
