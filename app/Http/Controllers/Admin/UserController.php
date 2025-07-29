<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // عرض قائمة المستخدمين
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->role) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->get();

        return view('admin.users', compact('users'));
    }

    // ترقية المستخدم إلى مشرف
    public function promote($id)
    {
        $user = User::findOrFail($id);
        $user->role = 'admin';
        $user->save();

        return back()->with('success', 'تمت ترقية المستخدم إلى مشرف.');
    }
}
