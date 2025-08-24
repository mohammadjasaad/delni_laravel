<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use Illuminate\Support\Facades\Hash;
use App\Events\DriverStatusUpdated;
use App\Events\DriverLocationUpdated;

class DriverController extends Controller
{
    // ✅ صفحة تسجيل الدخول (ويب)
    public function loginForm()
    {
        return view('taxi.drivers.login');
    }

    // ✅ تسجيل دخول (ويب)
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $driver = Driver::where('email', $request->email)->first();

        if ($driver && Hash::check($request->password, $driver->password)) {
            session(['driver_id' => $driver->id]);
            return redirect()->route('driver.panel')->with('success', 'تم تسجيل الدخول بنجاح');
        }

        return back()->withErrors(['email' => 'بيانات الدخول غير صحيحة']);
    }

    // ✅ لوحة تحكم السائق (باستخدام session driver_id)
    public function panel()
    {
        $driverId = session('driver_id');

        if (!$driverId) {
            return redirect()->route('driver.login')->withErrors(['unauthorized' => 'يجب تسجيل الدخول أولاً.']);
        }

        $driver = Driver::findOrFail($driverId);

        return view('taxi.drivers.panel', compact('driver'));
    }

    // ✅ خريطة كل السائقين (قديمة/للرجوع)
    public function map()
    {
        $drivers = Driver::whereNotNull('latitude')->whereNotNull('longitude')->get();
        return view('taxi.drivers.map', compact('drivers'));
    }

    // ✅ تعديل بيانات السائق (ويب)
    public function edit($id)
    {
        $driver = Driver::findOrFail($id);
        return view('taxi.drivers.edit', compact('driver'));
    }

    // ✅ تحديث حالة السائق (ويب)
public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:متاح,مشغول,غير متصل,خارج الخدمة',
    ]);

    $driver = Driver::findOrFail($id);
    $driver->status = $request->status;
    $driver->save();

    // 🔔 بثّ فوري لتحديث الخريطة إن توفرت إحداثيات
    $lat = $driver->latitude ?? $driver->lat ?? null;
    $lng = $driver->longitude ?? $driver->lon ?? null;

    if (is_numeric($lat) && is_numeric($lng)) {
        // يدعم توقيع الحدث القديم (id, lat, lng, status)
        broadcast(new DriverLocationUpdated($driver->id, (float)$lat, (float)$lng, (string)$driver->status))
            ->toOthers();
    }

    return redirect()->back()->with('success', '✅ تم تحديث حالة السائق.');
}
    // ✅ تعديل بيانات (ويب)
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'car_number' => 'required|string|max:255',
            'status'     => 'nullable|string',
            'latitude'   => 'nullable|numeric',
            'longitude'  => 'nullable|numeric',
        ]);

        $driver = Driver::findOrFail($id);

        $driver->update([
            'name'       => $request->name,
            'car_number' => $request->car_number,
            'status'     => $request->status,
            'latitude'   => $request->latitude,
            'longitude'  => $request->longitude,
        ]);

        // بثّ تحديث عام (قد يكون تغيير موقع أو حالة)
        event(new DriverStatusUpdated($driver));

        return redirect()->route('drivers.index')->with('success', '✅ تم تعديل بيانات السائق بنجاح');
    }

    // ✅ عرض ملف سائق
    public function show($id)
    {
        $driver = Driver::findOrFail($id);
        return view('taxi.drivers.show', compact('driver'));
    }

    // ✅ تسجيل جديد (ويب)
    public function showRegisterForm()
    {
        return view('taxi.drivers.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:drivers',
            'phone'    => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $driver = Driver::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'status'   => 'غير متصل',
        ]);

        session(['driver_id' => $driver->id]);

        // بثّ مبدئي (اختياري)
        event(new DriverStatusUpdated($driver));

        return redirect()->route('driver.panel')->with('success', '🚖 تم إنشاء حساب السائق وتسجيل الدخول.');
    }

    /**
     * ✅ تحديث موقع السائق (API) عبر المستخدم المصادق (توكن/جلسة)
     * ملاحظة: يعتمد على $request->user()؛ تأكد من ميدلوير المصادقة في المسار المقابل.
     */
    public function updateLocation(Request $request)
    {
        $request->validate([
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        /** @var \App\Models\Driver|null $driver */
        $driver = $request->user(); // يجلب السائق من التوكن (Sanctum/Passport) أو جلسة إن كانت مهيأة

        if (!$driver instanceof Driver) {
            return response()->json(['message' => '🚫 غير مصادق (سائق)'], 401);
        }

        // تحديث قاعدة البيانات
        $driver->latitude = $request->latitude;
        $driver->longitude = $request->longitude;
        if (!$driver->status) {
            $driver->status = 'متاح'; // افتراضي
        }
        $driver->save();

        // بث الموقع/الحالة عبر الحدث الموحد
        event(new DriverStatusUpdated($driver));

        return response()->json([
            'message' => '📍 تم تحديث موقع السائق وبثّه بنجاح',
            'driver'  => [
                'id'         => $driver->id,
                'name'       => $driver->name,
                'status'     => $driver->status,
                'latitude'   => (float) ($driver->lat ?? $driver->latitude),
                'longitude'  => (float) ($driver->lng ?? $driver->lon ?? $driver->longitude),
                'updated_at' => optional($driver->updated_at)->toISOString(),
            ],
        ]);
    }
}
