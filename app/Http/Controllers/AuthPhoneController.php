<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\OtpCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuthPhoneController extends Controller
{
    public function index()
    {
        return view('auth.phone-login');
    }

    public function sendCode(Request $request)
    {
        $request->validate([
            'phone' => 'required'
        ]);

        $phone = str_replace(' ', '', $request->phone);
        if (!str_starts_with($phone, '+')) {
            $phone = '+'.$phone;
        }

        $code = rand(100000, 999999);

        // حفظ الكود
        OtpCode::updateOrCreate(
            ['phone' => $phone],
            ['code' => $code, 'expires_at' => Carbon::now()->addMinutes(5)]
        );

        // إرسال عبر UltraMsg
        $url = "https://api.ultramsg.com/instance148483/messages/chat";
        $data = [
            "token" => "r71kpzkdwrp27nv9",
            "to" => $phone,
            "body" => "Delni.co 🔐\nرمز التحقق الخاص بك: $code"
        ];

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_RETURNTRANSFER => true,
        ]);
        curl_exec($ch);
        curl_close($ch);

        return response()->json(['status' => 'code_sent']);
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'code' => 'required'
        ]);

        $record = OtpCode::where('phone',$request->phone)->first();

        if (!$record || $record->isExpired() || $record->code != $request->code) {
            return response()->json(['status' => 'invalid']);
        }

        // إنشاء أو تسجيل دخول المستخدم
        $user = User::firstOrCreate(['phone' => $request->phone], [
            'name' => 'User '.$request->phone,
            'password' => bcrypt('password')
        ]);

        Auth::login($user);

        return response()->json(['status' => 'success']);
    }
}
