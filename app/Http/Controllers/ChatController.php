<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\NewMessageEvent;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        // تحقق من وجود رسالة
        $request->validate([
            'message' => 'required|string',
        ]);

        // بث الحدث
        broadcast(new NewMessageEvent($request->message))->toOthers();

        return response()->json([
            'status' => '✅ تم إرسال الرسالة عبر البث!',
            'message' => $request->message
        ]);
    }
}
