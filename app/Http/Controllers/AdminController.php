<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class AdminController extends Controller
{
    public function notifications()
    {
        // ✅ تأكد أن المستخدم مشرف
        abort_unless(auth()->user()->role === 'admin', 403);

        // ✅ جلب كل الإشعارات
        $notifications = DatabaseNotification::latest()->paginate(20);

        return view('admin.notifications', compact('notifications'));
    }
}
