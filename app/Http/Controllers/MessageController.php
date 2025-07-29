<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\NewMessage;

class MessageController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'sender' => 'required|string|max:255',
        ]);

        // بث الحدث
        broadcast(new NewMessage($request->message, $request->sender))->toOthers();

        return response()->json(['status' => 'Message sent successfully!']);
    }
}
