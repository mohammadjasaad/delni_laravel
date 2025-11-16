<?php

namespace App\Http\Controllers\Taxi;

use App\Http\Controllers\Controller;
use App\Models\TaxiOrder;
use App\Models\TaxiMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaxiChatController extends Controller
{
    // 🎯 صفحة محادثة الراكب
    public function showPassengerChat($order_id)
    {
        $order = TaxiOrder::findOrFail($order_id);
        $messages = TaxiMessage::where('order_id', $order_id)->get();

        return view('taxi.chat-passenger', compact('order', 'messages'));
    }

    // 🚖 صفحة محادثة السائق
    public function showDriverChat($order_id)
    {
        $order = TaxiOrder::findOrFail($order_id);
        $messages = TaxiMessage::where('order_id', $order_id)->get();

        return view('taxi.chat-driver', compact('order', 'messages'));
    }

    // 💬 إرسال رسالة
    public function store(Request $request)
    {
        TaxiMessage::create([
            'order_id' => $request->order_id,
            'sender_id' => Auth::id() ?? null,
            'sender_type' => $request->sender_type,
            'message' => $request->message,
        ]);

        return back();
    }
}
