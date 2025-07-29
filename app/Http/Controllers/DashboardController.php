<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\TaxiOrder;
use App\Models\EmergencyReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    // ✅ دالة عرض صفحة لوحة التحكم الرئيسية
    public function index()
    {
        return view('dashboard.index');
    }

    // ✅ عرض بيانات المستخدم
    public function myInfo()
    {
        $user = Auth::user();
        return view('dashboard.myinfo', compact('user'));
    }

    // ✅ صفحة تعديل بيانات المستخدم
public function editInfo()
{
    $user = auth()->user();
    return view('dashboard.editinfo', compact('user'));
}
    // ✅ تحديث بيانات المستخدم
public function updateInfo(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:6|confirmed',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->filled('password')) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    return redirect()->route('dashboard.myinfo')->with('success', '✅ تم تحديث بياناتك بنجاح.');
}
    // ✅ عرض الإعلانات الخاصة بالمستخدم مع فلترة المدينة والتصنيف
    public function myAds(Request $request)
    {
        $query = Ad::where('user_id', Auth::id());

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $ads = $query->latest()->get();

        return view('dashboard.myads', compact('ads'));
    }

    // ✅ عرض نموذج تعديل البيانات
    public function editMyInfo()
    {
        $user = auth()->user();
        return view('dashboard.edit-myinfo', compact('user'));
    }

    // ✅ تنفيذ التحديث
    public function updateMyInfo(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('dashboard.myinfo')->with('success', 'تم تحديث بياناتك بنجاح.');
    }

    // ✅ عرض نموذج تغيير كلمة المرور
    public function changePassword()
    {
        return view('dashboard.change-password');
    }

    // ✅ تنفيذ تغيير كلمة المرور
public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => ['required'],
        'new_password' => ['required', 'min:8', 'confirmed'],
    ]);

    $user = auth()->user();

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة']);
    }

    $user->update([
        'password' => Hash::make($request->new_password),
    ]);

    return back()->with('success', '✅ تم تغيير كلمة المرور بنجاح');
}

public function editPassword()
{
    return view('dashboard.edit-password');
}

    // ✅ عرض طلباتي (طلبات التاكسي وبلاغات الطوارئ)
    public function myOrders()
    {
        $user = auth()->user();

        $taxiOrders = TaxiOrder::where('user_id', $user->id)->latest()->get();
        $emergencyReports = EmergencyReport::where('user_id', $user->id)->latest()->get();

        return view('dashboard.myorders', compact('taxiOrders', 'emergencyReports'));
    }
}
