<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class WhatsappAuthController extends Controller
{
    // صفحة تسجيل الدخول بالهاتف
    public function loginPage()
    {
        return view('auth.login_phone');
    }

    // إرسال الكود عبر واتساب
public function sendCode(Request $request)
{
    $request->validate([
        'phone' => 'required|min:8',
    ]);

    $phone = preg_replace('/[^0-9]/', '', $request->phone); // تنظيف الرقم من الرموز

    // إنشاء أو جلب المستخدم
    $user = User::firstOrCreate(
        ['phone' => $phone],
        [
            'name' => 'مستخدم دلني',
            'password' => bcrypt('delni-temp-password') // كلمة مرور مؤقتة لا تُستخدم
        ]
    );

    // إنشاء كود 4 أرقام
    $code = rand(1111, 9999);

    $user->update([
        'whatsapp_code' => $code,
        'code_sent_at' => now(),
    ]);

    // 🎯 إرسال الكود عبر UltraMsg بدون أي تحويل
    $apiURL = "https://api.ultramsg.com/instance148483/messages/chat";
    $token  = "r71kpzkdwrp27nv9";

    $message = "رمز الدخول إلى Delni هو: *$code*\nيرجى إدخاله خلال 5 دقائق ✅";

    $payload = [
        'token'   => $token,
        'to'      => $phone,
        'body'    => $message
    ];

    try {
        $client = new \GuzzleHttp\Client();
        $client->post($apiURL, ['form_params' => $payload]);
    } catch (\Exception $e) {
        return back()->withErrors(['phone' => 'تعذر إرسال الرسالة ⚠️ تأكد أن جهاز الواتساب متصل']);
    }

    return redirect()->route('verify.code.page', ['phone' => $phone])
        ->with('success', '✅ تم إرسال الكود عبر واتساب بنجاح');
}

    // صفحة إدخال الكود
    public function verifyPage(Request $request)
    {
        return view('auth.verify_code', ['phone' => $request->phone]);
    }

    // التحقق من الكود
    public function verifyCode(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'code' => 'required',
        ]);

        $user = User::where('phone', $request->phone)
                    ->where('whatsapp_code', $request->code)
                    ->first();

        if (!$user) {
            return back()->withErrors(['code' => 'الرمز غير صحيح ❌']);
        }

        Auth::login($user);

        return redirect()->route('home')->with('success', 'تم تسجيل الدخول بنجاح ✅');
    }

    // تسجيل الخروج
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.phone');
    }
}
