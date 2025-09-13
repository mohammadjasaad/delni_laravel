<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // ✅ عرض المستخدمين في لوحة التحكم
public function index(Request $request)
{
    $query = User::query();

    // ✅ فلترة بالاسم أو البريد
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%");
        });
    }

    // ✅ فلترة بالدور (role)
    if ($request->has('role') && in_array($request->role, ['user', 'admin'])) {
        $query->where('role', $request->role);
    }

    $users = $query->orderBy('created_at', 'desc')->get();

    return view('dashboard.users.index', compact('users'));
}

    // ✅ ترقية مستخدم إلى مشرف
    public function makeAdmin($id)
    {
        $user = User::findOrFail($id);
        $user->role = 'admin';
        $user->save();

        return redirect()->route('dashboard.users.index')->with('success', '✔️ تم ترقية المستخدم إلى مشرف بنجاح.');
    }
// ✅ عرض جميع إعلانات مستخدم
public function ads($id)
{
    $user = User::findOrFail($id);
    $ads = $user->ads()->orderBy('created_at', 'desc')->paginate(12);

    return view('users.ads', compact('user', 'ads'));
}

}
