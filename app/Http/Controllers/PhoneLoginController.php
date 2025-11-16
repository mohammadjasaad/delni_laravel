<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PhoneLoginController extends Controller
{

public function sendCode(Request $request)
{
    $request->validate([
        'phone' => 'required'
    ]);

    $phone = preg_replace('/[^0-9]/', '', $request->phone);

    if (str_starts_with($phone, '09')) {
        $phone = '963' . substr($phone, 1);
    }
    if (!str_starts_with($phone, '963')) {
        $phone = '963' . $phone;
    }
    $phone = '+' . $phone;

    // ✅ إنشاء المستخدم إذا لم يكن موجود
    $user = User::updateOrCreate(
        ['phone' => $phone],
        ['name' => $phone]
    );

    // ✅ توليد كود 4 أرقام
    $code = rand(1111, 9999);

    // ✅ حفظ الكود
    $user->update(['whatsapp_code' => $code]);

    // ✅ إرسال عبر UltraMSG
    $instance = env('ULTRA_INSTANCE_ID');
    $token = env('ULTRA_TOKEN');

    $message = "رمز تسجيل الدخول الخاص بك في Delni هو: {$code} ✅\n\nلا تعطي هذا الرمز لأي شخص.";

    $params = [
        'token' => $token,
        'to' => $phone,
        'body' => $message,
    ];

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.ultramsg.com/{$instance}/messages/chat",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => http_build_query($params),
        CURLOPT_HTTPHEADER => ["content-type: application/x-www-form-urlencoded"],
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    \Log::info("UltraMSG Response → $response");

    return response()->json([
        'status' => 'success',
        'message' => '✅ تم إرسال رمز التحقق عبر واتساب'
    ]);
}

public function verifyCode(Request $request)
{
    $request->validate([
        'phone' => 'required',
        'code' => 'required'
    ]);

    $phone = preg_replace('/[^0-9]/', '', $request->phone);

    if (str_starts_with($phone, '09')) {
        $phone = '963' . substr($phone, 1);
    }
    if (!str_starts_with($phone, '963')) {
        $phone = '963' . $phone;
    }
    $phone = '+' . $phone;

    $user = User::where('phone', $phone)
        ->where('whatsapp_code', $request->code)
        ->first();

    if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => '❌ رمز غير صحيح'
        ], 401);
    }

    // ✅ توليد Token للموبايل
    $token = $user->createToken('mobile')->plainTextToken;

    return response()->json([
        'status' => 'success',
        'token'  => $token,
        'user'   => [
            'id' => $user->id,
            'name' => $user->name,
            'phone' => $user->phone,
        ]
    ], 200);
}
}
