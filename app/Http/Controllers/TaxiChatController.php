<?php

namespace App\Http\Controllers;

use App\Models\TaxiOrder;
use App\Models\TaxiMessage;
use App\Events\TaxiMessageSent;
use Illuminate\Http\Request;

class TaxiChatController extends Controller
{
    public function showPassengerChat($order_id)
    {
        $order = TaxiOrder::findOrFail($order_id);
        $messages = TaxiMessage::where('order_id', $order_id)->get();
        return view('taxi.chat-passenger', compact('order', 'messages'));
    }

    public function showDriverChat($order_id)
    {
        $order = TaxiOrder::findOrFail($order_id);
        $messages = TaxiMessage::where('order_id', $order_id)->get();
        return view('taxi.chat-driver', compact('order', 'messages'));
    }

    public function sendMessage(Request $request)
    {
        $message = TaxiMessage::create([
            'order_id' => $request->order_id,
            'sender_type' => $request->sender_type, // driver or passenger
            'message' => $request->message
        ]);

        broadcast(new TaxiMessageSent($message))->toOthers();

        return response()->json(['status' => 'sent']);
    }
}
