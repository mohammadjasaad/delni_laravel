<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DriverMessage;

class DriverMessageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'driver_name' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        DriverMessage::create([
            'driver_name' => $request->driver_name,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', '📩 تم إرسال رسالتك إلى السائق بنجاح.');
    }
}
