<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // ✅ عرض قائمة المستخدمين مع فلترة وترقيم
public function index(Request $request)
{
    $query = User::query();

    // 🔍 بحث
    if ($request->search) {
        $query->where(function($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%')
              ->orWhere('phone', 'like', '%' . $request->search . '%');
        });
    }

    // 🎭 فلترة حسب الدور
    if ($request->role) {
        $query->where('role', $request->role);
    }

    // 🔄 فرز
    if ($request->sort === 'oldest') {
        $query->orderBy('created_at', 'asc');
    } else {
        $query->orderBy('created_at', 'desc');
    }

    // 📊 جلب عدد الإعلانات لكل مستخدم
    $users = $query->withCount('ads')->paginate(15);

    return view('admin.users.index', compact('users'));
}

    // ✅ ترقية المستخدم إلى مشرف
    public function promote($id)
    {
        $user = User::findOrFail($id);
        $user->role = 'admin';
        $user->save();

        return back()->with('success', __('messages.promote_success'));
    }
// ✅ حظر / إلغاء حظر المستخدم
public function toggleBan($id)
{
    $user = \App\Models\User::findOrFail($id);

    if ($user->banned_at) {
        // 🔓 إلغاء الحظر
        $user->banned_at = null;
        $message = "✅ تم إلغاء الحظر عن المستخدم";
    } else {
        // 🚫 حظر المستخدم
        $user->banned_at = now();
        $message = "⛔ تم حظر المستخدم بنجاح";
    }

    $user->save();

    return back()->with('success', $message);
}
}
