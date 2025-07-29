<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaxiMessage;
use App\Models\TaxiOrder;

class TaxiMessageController extends Controller
{
    // إرجاع جميع الرسائل الخاصة بطلب معيّن
    public function index($order_id)
    {
        $messages = TaxiMessage::where('order_id', $order_id)->orderBy('created_at', 'asc')->get();
        return response()->json($messages);
    }

    // حفظ رسالة جديدة
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'sender' => 'required|string',
            'message' => 'required|string',
        ]);

        $message = TaxiMessage::create([
            'order_id' => $request->order_id,
            'sender' => $request->sender,
            'message' => $request->message,
        ]);

        return response()->json(['status' => 'sent', 'message' => $message]);
    }
// ✅ عرض المحادثة من جهة السائق
public function driverChat($orderId)
{
    // التأكد من وجود السائق ضمن الجلسة
    if (!session()->has('driver_id')) {
        return redirect()->route('driver.login')->with('error', 'يجب تسجيل الدخول أولاً.');
    }

    $order = \App\Models\TaxiOrder::with('user', 'driver')->findOrFail($orderId);

    // التأكد أن السائق هو صاحب الطلب
    if ($order->driver_id != session('driver_id')) {
        abort(403, 'غير مصرح لك بالوصول إلى هذه الصفحة.');
    }

    return view('taxi.chat.driver', compact('order'));
}
public function fetch()
{
    $orderId = request('order_id');
    return TaxiMessage::where('order_id', $orderId)->get();
}

// ✅ إرسال رسالة من السائق
public function driverReply(Request $request, $orderId)
{
    $request->validate([
        'message' => 'required|string',
    ]);

    TaxiMessage::create([
        'taxi_order_id' => $orderId,
        'sender_type' => 'driver',
        'message' => $request->message,
    ]);

    return back()->with('success', 'تم إرسال الرسالة بنجاح');
}

}
