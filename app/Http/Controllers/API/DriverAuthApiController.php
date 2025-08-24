<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class DriverAuthApiController extends Controller
{
    /**
     * ✅ تسجيل سائق جديد (API)
     * - يُنشئ السائق في جدول drivers
     * - يضبط الحالة الافتراضية "غير متصل"
     * - يُصدر توكن Sanctum إن كان مُفعّل
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:drivers,email'],
            'phone'    => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', Password::min(6)],
        ]);

        $driver = Driver::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'phone'    => $data['phone'],
            'password' => Hash::make($data['password']),
            'status'   => 'غير متصل',
        ]);

        // إصدار توكن Sanctum (إن كان مُفعّل)
        $token = null;
        if (method_exists($driver, 'createToken')) {
            $token = $driver->createToken('driver_api')->plainTextToken;
        }

        return response()->json([
            'message' => 'تم تسجيل السائق بنجاح',
            'driver'  => [
                'id'     => $driver->id,
                'name'   => $driver->name,
                'email'  => $driver->email,
                'phone'  => $driver->phone,
                'status' => $driver->status,
            ],
            'token'   => $token, // قد يكون null إذا Sanctum غير مُفعّل
        ], 201);
    }

    /**
     * ✅ تسجيل الدخول (API)
     * - يدعم التحقق من كلمة المرور
     * - يُصدر توكن Sanctum (Bearer) إن كان مُفعّل
     * - ويحافظ على التوافق مع حارس auth.driver لو أردت جلسة.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        /** @var \App\Models\Driver|null $driver */
        $driver = Driver::where('email', $credentials['email'])->first();

        if (!$driver || !Hash::check($credentials['password'], $driver->password)) {
            return response()->json([
                'message' => 'بيانات الدخول غير صحيحة',
            ], 422);
        }

        // تسجيل في حارس السائق (اختياري للجلسات)
        if (Auth::guard('driver')->check() === false) {
            Auth::guard('driver')->login($driver);
        }

        // إصدار توكن Sanctum (إن كان مُفعّل)
        $token = null;
        if (method_exists($driver, 'createToken')) {
            // ملاحظة: يمكن تقييد الصلاحيات في المصفوفة الثانية عند الحاجة
            $token = $driver->createToken('driver_api')->plainTextToken;
        }

        return response()->json([
            'message' => 'تم تسجيل الدخول بنجاح',
            'driver'  => [
                'id'       => $driver->id,
                'name'     => $driver->name,
                'email'    => $driver->email,
                'phone'    => $driver->phone,
                'status'   => $driver->status ?? 'غير متصل',
                'latitude' => $driver->lat ?? $driver->latitude,
                'longitude'=> $driver->lng ?? $driver->lon ?? $driver->longitude,
            ],
            'token'   => $token, // استخدمه مع /api/driver/update-location-token
        ]);
    }

    /**
     * ✅ تسجيل الخروج (API)
     * - يلغي توكن Sanctum الحالي (إن وجد)
     * - ويسجّل خروج حارس auth.driver (للجلسات)
     */
    public function logout(Request $request)
    {
        /** @var \App\Models\Driver|null $driver */
        $driver = $request->user(); // إن كان عبر Sanctum

        // إلغاء توكن Sanctum الحالي فقط (إن وجد)
        if ($driver && method_exists($driver, 'currentAccessToken') && $driver->currentAccessToken()) {
            $driver->currentAccessToken()->delete();
        }

        // تسجيل خروج جلسة حارس السائق (إن كانت مُستخدمة)
        if (Auth::guard('driver')->check()) {
            Auth::guard('driver')->logout();
            $request->session()?->invalidate();
            $request->session()?->regenerateToken();
        }

        return response()->json([
            'message' => 'تم تسجيل الخروج بنجاح',
        ]);
    }
}
