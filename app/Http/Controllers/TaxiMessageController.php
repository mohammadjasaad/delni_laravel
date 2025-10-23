<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaxiMessage;
use App\Models\TaxiOrder;
use App\Events\TaxiMessageSent; // ✅ لإرسال البث الفوري
use Illuminate\Support\Facades\Auth;

class TaxiMessageController extends Controller
{
    // ✅ إرجاع جميع الرسائل الخاصة بطلب معين
    public function index($order_id)
    {
        $messages = TaxiMessage::where('order_id', $order_id)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    // ✅ إضافة رسالة جديدة وبثّها فورًا
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:taxi_orders,id',
            'sender_type' => 'required|in:user,driver',
            'message' => 'required|string',
        ]);

        $message = TaxiMessage::create([
            'order_id' => $request->order_id,
            'sender_type' => $request->sender_type,
            'sender_id' => Auth::id() ?? 0, // الراكب أو السائق
            'message' => $request->message,
        ]);

        // ✅ بثّ الرسالة لجميع المشتركين في القناة الخاصة بالطلب
        broadcast(new TaxiMessageSent($message))->toOthers();

        return response()->json(['status' => 'sent', 'message' => $message]);
    }

    // ✅ صفحة دردشة السائق (واجهة Blade)
    public function driverChat($orderId)
    {
        if (!session()->has('driver_id')) {
            return redirect()->route('driver.login')->with('error', 'يجب تسجيل الدخول أولاً.');
        }

        $order = TaxiOrder::findOrFail($orderId);

        if ($order->driver_id != session('driver_id')) {
            abort(403, '🚫 غير مصرح لك بالدخول.');
        }

        return view('taxi.chat.driver', compact('order'));
    }

    // ✅ جلب الرسائل (API)
    public function fetch(Request $request)
    {
        $messages = TaxiMessage::where('order_id', $request->order_id)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    // ✅ رد السائق
    public function driverReply(Request $request, $orderId)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $message = TaxiMessage::create([
            'order_id' => $orderId,
            'sender_type' => 'driver',
            'sender_id' => session('driver_id') ?? 0,
            'message' => $request->message,
        ]);

        // ✅ بثّ الردّ مباشرة
        broadcast(new TaxiMessageSent($message))->toOthers();

        return back()->with('success', 'تم إرسال الرسالة بنجاح');
    }
}
