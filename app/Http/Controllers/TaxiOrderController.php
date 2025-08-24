<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\TaxiOrder;
use App\Models\Rating;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class TaxiOrderController extends Controller
{
    /**
     * 🚖 إنشاء طلب تاكسي وتخصيص أقرب سائق متاح + حساب السعر (مثال قديم موجود)
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_name'          => 'required|string|max:255',
            'pickup_latitude'    => 'required|numeric',
            'pickup_longitude'   => 'required|numeric',
            'dropoff_latitude'   => 'required|numeric',
            'dropoff_longitude'  => 'required|numeric',
            'destination_name'   => 'nullable|string|max:255',
        ]);

        $pickupLat = (float) $request->pickup_latitude;
        $pickupLng = (float) $request->pickup_longitude;
        $dropLat   = (float) $request->dropoff_latitude;
        $dropLng   = (float) $request->dropoff_longitude;

        // ✅ أقرب سائق متاح
        $driver = Driver::where('status', 'متاح')
            ->selectRaw(
                "*, (6371 * acos( cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)) )) AS distance",
                [$pickupLat, $pickupLng, $pickupLat]
            )
            ->orderBy('distance')
            ->first();

        if (!$driver) {
            return response()->json(['message' => 'لا يوجد سائق متاح حاليًا'], 404);
        }

        // ✅ تقدير المسافة/المدة/التكلفة
        $distanceKm = round(
            6371 * acos(
                cos(deg2rad($pickupLat)) * cos(deg2rad($dropLat)) *
                cos(deg2rad($dropLng) - deg2rad($pickupLng)) +
                sin(deg2rad($pickupLat)) * sin(deg2rad($dropLat))
            ),
            2
        );
        $durationMin = max(1, (int) round(($distanceKm / 40) * 60)); // 40 كم/س
        $cost        = max(1, (int) round(5 + ($distanceKm * 2)));   // مثال

        // ✅ إنشاء الطلب
        $order = TaxiOrder::create([
            'user_name'         => $request->user_name,
            'pickup_latitude'   => $pickupLat,
            'pickup_longitude'  => $pickupLng,
            'dropoff_latitude'  => $dropLat,
            'dropoff_longitude' => $dropLng,
            'destination_name'  => $request->destination_name,
            'distance_km'       => $distanceKm,
            'duration_min'      => $durationMin,
            'cost'              => $cost,
            'driver_id'         => $driver->id,
            'status'            => 'قيد التنفيذ',
        ]);

        // ✅ تغيير حالة السائق
        $driver->update(['status' => 'مشغول']);

        return response()->json([
            'message'  => 'تم إرسال الطلب بنجاح',
            'order_id' => $order->id,
            'order'    => $order,
            'driver'   => $driver,
        ]);
    }

    /** 🚦 بدء الرحلة */
    public function startRide($id)
    {
        $order = TaxiOrder::findOrFail($id);
        if ($order->status !== 'قيد التنفيذ') {
            return redirect()->back()->with('error', '🚫 لا يمكن بدء الرحلة في هذه المرحلة.');
        }
        $order->status = 'بدأت الرحلة';
        $order->save();
        return redirect()->back()->with('success', '🚦 تم بدء الرحلة بنجاح.');
    }

    /** 📍 حالة الطلب */
    public function showStatus($id)
    {
        $order  = TaxiOrder::findOrFail($id);
        $driver = Driver::find($order->driver_id);
        return view('taxi.order-status', compact('order', 'driver'));
    }

    /** ✅ إنهاء الرحلة */
    public function complete($id)
    {
        $order = TaxiOrder::findOrFail($id);
        $order->update(['status' => 'منتهي']);

        if ($order->driver_id) {
            $driver = Driver::find($order->driver_id);
            if ($driver) $driver->update(['status' => 'متاح']);
        }

        return response()->json(['message' => 'تم إنهاء الرحلة بنجاح']);
    }

    /** ⭐ إنهاء الرحلة مع تقييم السائق */
    public function completeWithRating(Request $request)
    {
        $request->validate([
            'order_id'    => 'required|exists:taxi_orders,id',
            'driver_id'   => 'required|exists:drivers,id',
            'driver_name' => 'required|string|max:255',
            'rating'      => 'required|numeric|min:1|max:5',
            'comment'     => 'nullable|string|max:1000',
        ]);

        $order = TaxiOrder::findOrFail($request->order_id);
        $order->update(['status' => 'منتهي']);

        $driver = Driver::find($request->driver_id);
        if ($driver) $driver->update(['status' => 'متاح']);

        Rating::create([
            'driver_id'   => $request->driver_id,
            'order_id'    => $request->order_id,
            'driver_name' => $request->driver_name,
            'rating'      => $request->rating,
            'stars'       => (int) $request->rating,
            'comment'     => $request->comment,
        ]);

        return redirect()->route('trip.completed')->with('success', '✅ تم إنهاء الرحلة وتسجيل التقييم.');
    }

    /** ❌ إلغاء الطلب */
    public function cancel($id)
    {
        $order = TaxiOrder::findOrFail($id);
        $order->update(['status' => 'ملغي']);

        if ($order->driver_id) {
            $driver = Driver::find($order->driver_id);
            if ($driver) $driver->update(['status' => 'متاح']);
        }

        return response()->json(['message' => 'تم إلغاء الطلب']);
    }

    /** شاشة إنشاء (مثال) */
    public function create()
    {
        $drivers = Driver::orderBy('name')->get(['id','name','status']);
        return view('taxi_orders.create', compact('drivers'));
    }

    /** ✅ حفظ الطلب القادم من الخريطة */
public function storeFromMap(Request $request)
{
    // ✅ التحقق من البيانات
    $request->validate([
        'pickup_latitude'  => 'required|numeric',
        'pickup_longitude' => 'required|numeric',
        'dropoff_latitude' => 'required|numeric',
        'dropoff_longitude'=> 'required|numeric',
        'distance_km'      => 'nullable|numeric',
        'duration_min'     => 'nullable|numeric',
        'cost'             => 'nullable|numeric',
    ]);

    // ✅ الحصول على أقرب سائق
    $nearestDriver = \DB::table('drivers')
        ->where('status', 'متاح')
        ->whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->select('id', 'name', 'latitude', 'longitude')
        ->first();

    if (!$nearestDriver) {
        return back()->with('error', 'لا يوجد سائق متاح حالياً.');
    }

    // ✅ إنشاء الطلب
    $order = \App\Models\TaxiOrder::create([
        'user_id'         => auth()->id(),
        'user_name'       => auth()->user()->name,
        'pickup_latitude' => $request->pickup_latitude,
        'pickup_longitude'=> $request->pickup_longitude,
        'dropoff_latitude'=> $request->dropoff_latitude,
        'dropoff_longitude'=> $request->dropoff_longitude,
        'distance_km'     => $request->distance_km,
        'duration_min'    => $request->duration_min,
        'cost'            => $request->cost,
        'status'          => 'في الانتظار',
        'driver_id'       => $nearestDriver->id,
    ]);

    // ✅ إعادة التوجيه لصفحة حالة الطلب
    return redirect()->route('taxi.order.status', ['id' => $order->id])
        ->with('success', 'تم إرسال طلبك بنجاح، جاري البحث عن أقرب سائق...');
}
public function orderStatus($id)
{
    $order = \App\Models\TaxiOrder::with('driver')->findOrFail($id);
    return view('taxi.order-status', compact('order'));
}
public function apiStore(Request $request)
    {
        $request->validate([
            'pickup_latitude'   => 'required|numeric',
            'pickup_longitude'  => 'required|numeric',
            'dropoff_latitude'  => 'required|numeric',
            'dropoff_longitude' => 'required|numeric',
            'destination_name'  => 'nullable|string|max:255',
        ]);

        $pickupLat = (float) $request->pickup_latitude;
        $pickupLng = (float) $request->pickup_longitude;
        $dropLat   = (float) $request->dropoff_latitude;
        $dropLng   = (float) $request->dropoff_longitude;

        // ✅ البحث عن أقرب سائق متاح
        $driver = Driver::where('status', 'متاح')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->selectRaw(
                "*, (6371 * acos( cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)) )) AS distance",
                [$pickupLat, $pickupLng, $pickupLat]
            )
            ->orderBy('distance')
            ->first();

        if (!$driver) {
            return response()->json(['message' => '🚫 لا يوجد سائق متاح حالياً'], 404);
        }

        // ✅ حساب المسافة/المدة/التكلفة
        $distanceKm = round(
            6371 * acos(
                cos(deg2rad($pickupLat)) * cos(deg2rad($dropLat)) *
                cos(deg2rad($dropLng) - deg2rad($pickupLng)) +
                sin(deg2rad($pickupLat)) * sin(deg2rad($dropLat))
            ),
            2
        );
        $durationMin = max(1, (int) round(($distanceKm / 40) * 60)); // 40 كم/س
        $cost        = max(1, (int) round(5 + ($distanceKm * 2)));

        // ✅ إنشاء الطلب
        $order = TaxiOrder::create([
            'user_id'          => $request->user()->id ?? null,
            'user_name'        => $request->user()->name ?? 'مجهول',
            'pickup_latitude'  => $pickupLat,
            'pickup_longitude' => $pickupLng,
            'dropoff_latitude' => $dropLat,
            'dropoff_longitude'=> $dropLng,
            'destination_name' => $request->destination_name,
            'distance_km'      => $distanceKm,
            'duration_min'     => $durationMin,
            'cost'             => $cost,
            'driver_id'        => $driver->id,
            'status'           => 'قيد التنفيذ',
        ]);

        // تغيير حالة السائق إلى مشغول
        $driver->update(['status' => 'مشغول']);

        return response()->json([
            'message'  => '✅ تم إنشاء الطلب بنجاح',
            'order_id' => $order->id,
            'order'    => $order,
            'driver'   => $driver,
        ]);
    }
}
