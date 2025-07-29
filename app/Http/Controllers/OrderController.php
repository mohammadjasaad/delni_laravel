<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\Driver;

class OrderController extends Controller
{
public function store(Request $request)
{
    $lat = $request->input('lat');
    $lng = $request->input('lng');

    // ❗ يمكنك هنا لاحقًا حفظ الطلب في قاعدة البيانات أو ربطه بسائق
    return redirect()->route('order.status')->with('success', '🚖 تم إرسال طلبك من الإحداثيات: ' . $lat . ', ' . $lng);
}
public function status()
{
    // استدعاء آخر طلب للمستخدم
    $order = TaxiOrder::latest()->where('user_id', auth()->id())->first();

    // التحقق من وجود الطلب
    if (!$order) {
        return redirect()->back()->with('error', 'لا يوجد طلب حالي');
    }

    // جلب السائق المرتبط بالطلب
    $driver = $order->driver;

    return view('taxi.order-status', compact('order', 'driver'));
}

}
