<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Rating;
use App\Models\TaxiOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

class TaxiController extends Controller
{
    // ✅ عرض صفحة التاكسي الرئيسية
    public function index()
    {
        $drivers = Driver::where('status', 'متاح')->get();
        $userLat = 33.5138; // دمشق كمثال
        $userLng = 36.2765;
        $nearestDriver = $drivers->first();

        $activeOrder = null;
        if (auth()->check() && Schema::hasColumn('taxi_orders', 'user_id')) {
            $activeOrder = TaxiOrder::where('user_id', auth()->id())
                ->whereIn('status', ['قيد التنفيذ', 'بانتظار السائق'])
                ->latest()
                ->first();
        }

        return view('taxi.delni-taxi', compact(
            'drivers',
            'userLat',
            'userLng',
            'nearestDriver',
            'activeOrder'
        ));
    }

    // ✅ صفحة تعريف الخدمة
    public function landing()
    {
        return view('taxi.landing');
    }

    // ✅ عرض صفحة طلب التاكسي
    public function showOrderPage($driverId)
    {
        $driver = Driver::findOrFail($driverId);
        $order = null;

        if (auth()->check()) {
            $order = TaxiOrder::where('user_id', auth()->id())
                ->whereIn('status', ['في الانتظار', 'بإختيار السائق'])
                ->latest()
                ->first();
        }

        return view('order-taxi', compact('driver', 'order'));
    }

    // ✅ API: جلب موقع السائق
    public function driverLocation($id)
    {
        $driver = Driver::find($id);
        if (!$driver) {
            return response()->json(['error' => 'Driver not found'], 404);
        }

        // ⚡ شرط احترافي: لازم يكون السائق "متاح"
        if ($driver->status !== 'متاح') {
            return response()->json(['error' => 'Driver not available'], 403);
        }

        return response()->json([
            'id'        => $driver->id,
            'name'      => $driver->name,
            'phone'     => $driver->phone,
            'latitude'  => $driver->latitude,
            'longitude' => $driver->longitude,
            'status'    => $driver->status,
            'is_active' => (int) $driver->is_active,
            'updated_at'=> $driver->updated_at,
        ], 200);
    }

    // (اختياري) تحديث موقع السائق عبر POST باستخدام ID
    public function updateDriverLocation(Request $request, $id)
    {
        $data = $request->validate([
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $driver = Driver::find($id);
        if (!$driver) {
            return response()->json(['error' => 'Driver not found'], 404);
        }

        $driver->latitude  = (float) $data['latitude'];
        $driver->longitude = (float) $data['longitude'];
        $driver->save();

        // 🔴 بثّ التغيير لحظيًا عبر Pusher
        event(new \App\Events\DriverLocationUpdated(
            driver_id: $driver->id,
            latitude:  (float) $driver->latitude,
            longitude: (float) $driver->longitude,
            status:    $driver->status,
            updated_at_iso: $driver->updated_at?->toISOString() ?? now()->toISOString()
        ));

        return response()->json([
            'message'    => 'Driver location updated',
            'id'         => $driver->id,
            'latitude'   => (float) $driver->latitude,
            'longitude'  => (float) $driver->longitude,
            'updated_at' => $driver->updated_at,
        ], 200);
    }

    // ✅ API جديد: تحديث موقع السائق باستخدام التوكن (Sanctum)
    public function updateLocationFromDriver(Request $request)
    {
        $data = $request->validate([
            'order_id'  => 'required|integer',
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // ⚡ جلب السائق من التوكن (auth('driver'))
        $driver = Auth::guard('driver')->user();

        if (!$driver) {
            return response()->json(['message' => '🚫 غير مصادق كسائق'], 401);
        }

        $driver->latitude  = $data['latitude'];
        $driver->longitude = $data['longitude'];
        $driver->status    = 'متاح'; // تحديث الحالة تلقائيًا عند الإرسال
        $driver->save();

        // 🔴 بثّ التغيير عبر Pusher
        event(new \App\Events\DriverLocationUpdated(
            driver_id: $driver->id,
            latitude:  (float) $driver->latitude,
            longitude: (float) $driver->longitude,
            status:    $driver->status,
            updated_at_iso: $driver->updated_at?->toISOString() ?? now()->toISOString()
        ));

        return response()->json([
            'message'    => '📍 تم تحديث الموقع بنجاح',
            'driver_id'  => $driver->id,
            'latitude'   => (float) $driver->latitude,
            'longitude'  => (float) $driver->longitude,
            'order_id'   => $data['order_id'],
            'updated_at' => $driver->updated_at,
        ], 200);
    }

    // ✅ عرض خريطة كل السائقين
    public function showDriversMap()
    {
        $drivers = Driver::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return view('taxi.drivers-map', compact('drivers'));
    }

    // ✅ صفحة إنهاء الرحلة + التقييم
    public function tripCompleted(Request $request)
    {
        $driver = Driver::first();
        $rating = Rating::latest()
            ->where('driver_name', optional($driver)->name)
            ->first();

        return view('taxi.order-completed', compact('driver', 'rating'));
    }

    // ✅ API: جميع السائقين (JSON)
    public function getDriversJson()
    {
        $drivers = Driver::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return response()->json($drivers);
    }

    // ✅ نسخة موحدة لعرض Delni Taxi
    public function showDelniTaxi()
    {
        $drivers = Driver::where('status', 'متاح')->get();
        $userLat = 33.5138;
        $userLng = 36.2765;
        $nearestDriver = $drivers->first();

        $activeOrder = null;
        if (auth()->check() && Schema::hasColumn('taxi_orders', 'user_id')) {
            $activeOrder = TaxiOrder::where('user_id', auth()->id())
                ->whereIn('status', ['قيد التنفيذ', 'بانتظار السائق'])
                ->latest()
                ->first();
        }

        return view('taxi.delni-taxi', compact(
            'drivers',
            'userLat',
            'userLng',
            'nearestDriver',
            'activeOrder'
        ));
    }
}

