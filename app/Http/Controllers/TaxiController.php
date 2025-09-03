<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Rating;
use App\Models\TaxiDriver;
use Illuminate\Http\Request;

class TaxiController extends Controller
{
    // عرض صفحة التاكسي الرئيسية
public function index()
{
    // ✅ استرجاع السائقين المتاحين فقط
    $drivers = \App\Models\Driver::where('status', 'متاح')->get();

    // ✅ تحديد موقع المستخدم مبدئياً (دمشق مثالاً)
    $userLat = 33.5138;
    $userLng = 36.2765;

    // ✅ أقرب سائق (مبدئيًا نأخذ أول واحد)
    $nearestDriver = $drivers->first();

    // ✅ الطلب الجاري للمستخدم الحالي (إن وجد)
    $activeOrder = null;
    if (auth()->check()) {
        $activeOrder = \App\Models\TaxiOrder::where('user_id', auth()->id())
                        ->whereIn('status', ['قيد التنفيذ', 'بانتظار السائق'])
                        ->orderBy("created_at","desc")
                        ->first();
    }

    // ✅ إرسال كل شيء للواجهة
    return view('taxi.delni-taxi', compact(
        'drivers',
        'userLat',
        'userLng',
        'nearestDriver',
        'activeOrder'
    ));
}

    // جلب موقع السائق حسب ID
    public function driverLocation($id)
    {
        $driver = TaxiDriver::findOrFail($id);
        return response()->json([
            'latitude' => $driver->latitude,
            'longitude' => $driver->longitude,
        ]);
    }

    // عرض خريطة كل السائقين
    public function showDriversMap()
    {
        $drivers = Driver::whereNotNull('latitude')
                         ->whereNotNull('longitude')
                         ->get();

        return view('taxi.drivers-map', compact('drivers'));
    }

    // عرض صفحة إنهاء الرحلة مع التقييم
    public function tripCompleted(Request $request)
    {
        $driver = Driver::first(); // مؤقتًا نستخدم أول سائق
        $rating = Rating::latest()
                        ->where('driver_name', $driver->name)
                        ->first();

        return view('taxi.order-completed', compact('driver', 'rating'));
    }

    // API: جلب كل السائقين مع إحداثياتهم
    public function getDriversJson()
    {
        $drivers = Driver::whereNotNull('latitude')
                         ->whereNotNull('longitude')
                         ->get();

        return response()->json($drivers);
    }
public function showDelniTaxi()
{
    // ✅ استرجاع السائقين المتاحين فقط
    $drivers = \App\Models\Driver::where('status', 'متاح')->get();

    // ✅ تحديد إحداثيات المستخدم الافتراضية (يمكن ربطها بالموقع الحقيقي لاحقاً)
    $userLat = 33.5138; // دمشق كمثال
    $userLng = 36.2765;

    // ✅ إيجاد أقرب سائق (اختياري حالياً – سنحسبه لاحقاً)
    $nearestDriver = $drivers->first(); // مؤقتاً نأخذ أول سائق

    // ✅ الطلب الحالي للمستخدم إن وجد
    $activeOrder = null;
    if (auth()->check()) {
        $activeOrder = \App\Models\TaxiOrder::where('user_id', auth()->id())
                        ->whereIn('status', ['قيد التنفيذ', 'بانتظار السائق'])
                        ->orderBy("created_at","desc")
                        ->first();
    }

    // ✅ تمرير البيانات إلى واجهة العرض
    return view('taxi.delni-taxi', compact(
        'drivers',
        'userLat',
        'userLng',
        'nearestDriver',
        'activeOrder'
    ));
}

}
