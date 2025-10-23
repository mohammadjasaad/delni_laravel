<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaxiOrder;
use App\Models\Driver;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // 🟡 إنشاء الطلب من صفحة request.blade.php
    public function store(Request $request)
    {
        // ✅ إذا المستخدم غير مسجل دخول
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', '⚠️ يجب تسجيل الدخول أولاً قبل طلب التاكسي.');
        }

        $lat = $request->input('lat');
        $lng = $request->input('lng');

        // ✅ حفظ الطلب في قاعدة البيانات
        $order = TaxiOrder::create([
            'user_id' => Auth::id(),
            'pickup_lat' => $lat,
            'pickup_lng' => $lng,
            'status' => 'pending',
        ]);

        // ✅ التوجيه إلى صفحة حالة الطلب
        return redirect()->route('taxi.order.status', ['id' => $order->id])
            ->with('success', '🚖 تم إرسال طلبك بنجاح!');
    }

    // 🟢 صفحة حالة الطلب (تحويل تلقائي للمسار الصحيح)
    public function status($id)
    {
        // ✅ إعادة توجيه نحو TaxiOrderController لعرض الحالة
        return redirect()->route('taxi.order.status', ['id' => $id]);
    }
}
