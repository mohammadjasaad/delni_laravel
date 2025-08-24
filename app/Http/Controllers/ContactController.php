<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|string|max:2000',
        ]);

        // يمكنك إرسال الإيميل هنا أو تخزين الرسالة في قاعدة البيانات
        // في هذا المثال فقط نعرض رسالة نجاح

        return back()->with('success', __('messages.message_sent_successfully'));
    }
}
