<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\User;
use App\Models\TaxiOrder;
use App\Models\EmergencyReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    // 🏠 لوحة التحكم الرئيسية
    public function index()
    {
        $user = Auth::user();

        // 📊 إحصائيات المستخدم
        $myAdsCount            = $user->ads()->count();
        $featuredAdsCount      = $user->ads()->where('is_featured', 1)->count();
        $normalAdsCount        = $user->ads()->where('is_featured', 0)->count();
        $favoritesCount        = method_exists($user, 'favorites') ? $user->favorites()->count() : 0;
        $ordersCount           = TaxiOrder::where('user_id', $user->id)->count();
        $emergencyReportsCount = method_exists($user, 'emergencyReports') ? $user->emergencyReports()->count() : 0;

        // 📊 إحصائيات المشرف
        $adminStats = [];
        if ($user->role === 'admin') {
            $adminStats = [
                'usersCount'   => User::count(),
                'adsCount'     => Ad::count(),
                'reportsCount' => EmergencyReport::count(),
                'taxiOrders'   => TaxiOrder::count(),
            ];
        }

        // 🔔 إشعارات (آخر 5)
        $notifications = $user->notifications()->latest()->take(5)->get();

        return view('dashboard.index', compact(
            'myAdsCount',
            'featuredAdsCount',
            'normalAdsCount',
            'favoritesCount',
            'ordersCount',
            'emergencyReportsCount',
            'adminStats',
            'notifications'
        ));
    }

    // 👤 بياناتي
    public function myInfo()
    {
        $user = Auth::user();
        return view('dashboard.myinfo', compact('user'));
    }

    // ✏️ تعديل بياناتي
    public function editInfo()
    {
        $user = Auth::user();
        return view('dashboard.editinfo', compact('user'));
    }

    public function updateInfo(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('dashboard.myinfo')
            ->with('success', __('messages.profile_updated'));
    }

    // 📢 إعلاناتي
    public function myAds(Request $request)
    {
        $query = Ad::where('user_id', auth()->id());

        // 🌍 فلترة المدينة
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        // 📂 فلترة التصنيف
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // ⭐ فلترة حالة الإعلان
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured);
        }

        // 💰 فلترة السعر
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // 🔄 الترتيب
        switch ($request->get('sort')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->orderBy('is_featured', 'desc')
                      ->orderBy('created_at', 'desc');
                break;
        }

        // 📦 استعلام رئيسي
        $ads = $query->paginate(12)->appends($request->query());

        // 📊 إحصائيات إضافية
        $totalCount    = Ad::where('user_id', auth()->id())->count();
        $featuredCount = Ad::where('user_id', auth()->id())->where('is_featured', 1)->count();
        $normalCount   = Ad::where('user_id', auth()->id())->where('is_featured', 0)->count();

        return view('dashboard.myads', compact(
            'ads',
            'totalCount',
            'featuredCount',
            'normalCount'
        ));
    }

public function favorites(Request $request)
{
    $user = Auth::user();

    // 📦 استعلام المفضلة مع الإعلانات
    $query = Ad::whereHas('favorites', function($q) use ($user) {
        $q->where('user_id', $user->id);
    });

    // 🌍 فلترة المدينة
    if ($request->filled('city')) {
        $query->where('city', $request->city);
    }

    // 📂 فلترة التصنيف
    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }

    // ⭐ فلترة حالة الإعلان
    if ($request->filled('featured')) {
        $query->where('is_featured', $request->featured);
    }

    // 🔄 الترتيب
    switch ($request->get('sort')) {
        case 'price_asc':
            $query->orderBy('price', 'asc');
            break;
        case 'price_desc':
            $query->orderBy('price', 'desc');
            break;
        default:
            $query->orderBy('is_featured', 'desc')
                  ->orderBy('created_at', 'desc');
            break;
    }

    // 📄 النتائج مع Pagination
    $favorites = $query->paginate(12)->appends($request->query());

    return view('dashboard.favorites', compact('favorites'));
}

    // 🔑 تغيير كلمة المرور
    public function editPassword()
    {
        return view('dashboard.edit-password');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', __('messages.incorrect_password'));
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', __('messages.password_updated'));
    }

    // 🚖+🚨 طلباتي
    public function myOrders()
    {
        $user = Auth::user();

        $taxiOrders = TaxiOrder::where('user_id', $user->id)->latest()->get();
        $emergencyReports = EmergencyReport::where('user_id', $user->id)->latest()->get();

        return view('dashboard.myorders', compact('taxiOrders', 'emergencyReports'));
    }

    // 📊 إحصائياتي
    public function userStats()
    {
        $user = Auth::user();

        $myAdsCount            = $user->ads()->count();
        $featuredAdsCount      = $user->ads()->where('is_featured', 1)->count();
        $normalAdsCount        = $user->ads()->where('is_featured', 0)->count();
        $favoritesCount        = method_exists($user, 'favorites') ? $user->favorites()->count() : 0;
        $ordersCount           = TaxiOrder::where('user_id', $user->id)->count();
        $emergencyReportsCount = method_exists($user, 'emergencyReports') ? $user->emergencyReports()->count() : 0;

        return view('dashboard.user-stats', compact(
            'myAdsCount',
            'featuredAdsCount',
            'normalAdsCount',
            'favoritesCount',
            'ordersCount',
            'emergencyReportsCount'
        ));
    }

    // 🔔 الإشعارات
    public function notifications()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->latest()->paginate(15);

        return view('dashboard.notifications', compact('notifications'));
    }

    // ✅ تمييز الكل كمقروء
    public function markAllRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', __('messages.all_marked_as_read'));
    }

    // ✅ تمييز إشعار واحد كمقروء
    public function markRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        if ($notification) {
            $notification->markAsRead();
        }
        return back()->with('success', __('messages.marked_as_read'));
    }
// ✅ عرض تفاصيل الطلب داخل لوحة التحكم
public function showOrder($id)
{
    $order = \App\Models\Order::with(['items.product'])
        ->where('user_id', auth()->id())
        ->findOrFail($id);

    return view('dashboard.orders.show', compact('order'));
}
}
