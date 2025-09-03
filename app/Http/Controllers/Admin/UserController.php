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

        if ($request->role) {
            $query->where('role', $request->role);
        }

        // ✅ استخدام paginate بدل get
        $users = $query->orderBy("created_at","desc")->paginate(15);

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
}
