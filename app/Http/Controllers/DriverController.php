<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;

class DriverController extends Controller
{
// ✅ عرض صفحة تسجيل الدخول
public function loginForm()
{
    return view('taxi.drivers.login');
}

// ✅ تنفيذ عملية تسجيل الدخول
public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $driver = \App\Models\Driver::where('email', $request->email)->first();

    if ($driver && \Hash::check($request->password, $driver->password)) {
        session(['driver_id' => $driver->id]);
        return redirect()->route('driver.panel')->with('success', 'تم تسجيل الدخول بنجاح');
    }

    return back()->withErrors(['email' => 'بيانات الدخول غير صحيحة']);
}
public function panel()
{
    $driverId = session('driver_id');

    if (!$driverId) {
        return redirect()->route('driver.login')->withErrors(['unauthorized' => 'يجب تسجيل الدخول أولاً.']);
    }

    $driver = \App\Models\Driver::findOrFail($driverId);

    return view('taxi.drivers.panel', compact('driver'));
}

// ✅ عرض خريطة جميع السائقين
public function map()
{
    $drivers = \App\Models\Driver::whereNotNull('lat')->whereNotNull('lon')->get();
    return view('taxi.drivers.map', compact('drivers'));
}

// ✅ عرض نموذج التعديل
public function edit($id)
{
    $driver = Driver::findOrFail($id);
    return view('taxi.drivers.edit', compact('driver'));
}

// ✅ حفظ التعديلات
public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:متاح,مشغول,غير متصل',
    ]);

    $driver = Driver::findOrFail($id);
    $driver->status = $request->status;
    $driver->save();

    return redirect()->back()->with('success', '✅ تم تحديث حالة السائق التشغيلية.');
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'car_number' => 'required|string|max:255',
        'status' => 'nullable|string',
        'lat' => 'nullable|numeric',
        'lon' => 'nullable|numeric',
    ]);

    $driver = Driver::findOrFail($id);

    $driver->update([
        'name' => $request->name,
        'car_number' => $request->car_number,
        'status' => $request->status,
        'lat' => $request->lat,
        'lon' => $request->lon,
    ]);

    return redirect()->route('drivers.index')->with('success', '✅ تم تعديل بيانات السائق بنجاح');
}
public function show($id)
{
    $driver = Driver::findOrFail($id);
    return view('taxi.drivers.show', compact('driver'));
  }
}
