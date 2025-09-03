<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // 🔔 جميع الإشعارات
    public function notifications()
    {
        $admin = Auth::user();
        $notifications = $admin->notifications()->latest()->paginate(15);

        return view('admin.notifications', compact('notifications'));
    }

    // 👁️ تحديد إشعار كمقروء
    public function markAsRead($id)
    {
        $admin = Auth::user();
        $notification = $admin->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
            return back()->with('success', __('messages.marked_as_read'));
        }

        return back()->with('error', __('messages.something_went_wrong'));
    }

    // ✅ تحديد الكل كمقروء
    public function markAllAsRead()
    {
        $admin = Auth::user();
        $admin->unreadNotifications->markAsRead();

        return back()->with('success', __('messages.all_marked_as_read'));
    }
}

