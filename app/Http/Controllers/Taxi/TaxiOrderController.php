<?php

namespace App\Http\Controllers\Taxi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\TaxiOrder;
use App\Models\TaxiMessage;
use App\Services\TaxiPricingService;

class TaxiOrderController extends Controller
{
    /**
     * 🚖 إنشاء طلب تاكسي + تخصيص أقرب سائق
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'          => 'nullable|numeric',
            'pickup_latitude'  => 'required|numeric',
            'pickup_longitude' => 'required|numeric',
            'distance_km'      => 'nullable|numeric',
            'route_polyline'   => 'nullable|string',
        ]);

        $pickupLat = $request->pickup_latitude;
        $pickupLng = $request->pickup_longitude;

        // 🔍 إيجاد أقرب سائق متاح
        $driver = Driver::where('status', 'available')
            ->selectRaw(
                "*, (6371 * acos( cos(radians(?)) * cos(radians(latitude)) * 
                cos(radians(longitude) - radians(?)) + sin(radians(?)) * 
                sin(radians(latitude)) )) AS distance",
                [$pickupLat, $pickupLng, $pickupLat]
            )
            ->orderBy('distance')
            ->first();

        if (!$driver) {
            return response()->json(['message' => '🚫 لا يوجد سائق متاح حالياً'], 404);
        }

        // ✅ إنشاء الطلب
        $order = TaxiOrder::create([
            'user_id'          => $request->user_id,
            'pickup_latitude'  => $pickupLat,
            'pickup_longitude' => $pickupLng,
            'driver_id'        => $driver->id,
            'status'           => 'pending',
        ]);

        // 🚕 السائق أصبح مشغول
        $driver->update(['status' => 'busy']);

        // ✅ حساب السعر والمسافة والمسار إذا تم إرسالها من الواجهة
        if ($request->filled('distance_km')) {

            $pricing = new TaxiPricingService();

            $order->distance_km = $request->distance_km;
            $order->fare_syp    = $pricing->quote($request->distance_km);

            if ($request->route_polyline) {
                $order->route_polyline = $request->route_polyline;
            }

            $order->save();
        }

        // إذا الطلب AJAX → نرجع رابط المتابعة
        if ($request->expectsJson() || $request->isJson()) {
            return response()->json([
                'redirect' => route('taxi.order.status', ['id' => $order->id])
            ]);
        }

        // وإلا → Redirect عادي
        return redirect()->route('taxi.order.status', ['id' => $order->id])
            ->with('success', '✅ تم إرسال الطلب بنجاح.');
    }

    /**
     * 📍 صفحة متابعة الطلب (Uber Style)
     */
    public function showStatus($id)
    {
        $order = TaxiOrder::with('driver')->findOrFail($id);
        $driver = $order->driver;

        return view('taxi.order-status', compact('order', 'driver'));
    }

    /**
     * 🔄 تحديث Realtime كل عدة ثوانٍ
     */
    public function updateRealtime($id)
    {
        $order = TaxiOrder::with('driver')->find($id);

        if (!$order) {
            return response()->json(['error' => '🚫 الطلب غير موجود'], 404);
        }

        return response()->json([
            'status' => $order->status,
            'driver' => $order->driver ? [
                'id'         => $order->driver->id,
                'name'       => $order->driver->name,
                'car_model'  => $order->driver->car_model,
                'car_number' => $order->driver->car_number,
                'phone'      => $order->driver->phone,
                'latitude'   => $order->driver->latitude,
                'longitude'  => $order->driver->longitude,
            ] : null,
            'distance_km' => $order->distance_km,
            'fare_syp'    => $order->fare_syp,
            'route_polyline' => $order->route_polyline,
        ]);
    }

    /**
     * 🚦 بدء الرحلة
     */
    public function startRide($id)
    {
        $order = TaxiOrder::findOrFail($id);

        if ($order->status !== 'accepted') {
            return back()->with('error', '🚫 لا يمكن بدء الرحلة الآن.');
        }

        $order->update(['status' => 'ongoing']);
        return back()->with('success', '🚦 تم بدء الرحلة.');
    }

    /**
     * ✅ إنهاء الرحلة
     */
    public function complete($id)
    {
        $order = TaxiOrder::findOrFail($id);
        $order->update(['status' => 'completed']);

        if ($order->driver_id) {
            Driver::where('id', $order->driver_id)->update(['status' => 'available']);
        }

        return response()->json(['message' => '✅ تم إنهاء الرحلة بنجاح']);
    }

    /**
     * ❌ إلغاء الطلب
     */
    public function cancel($id)
    {
        $order = TaxiOrder::findOrFail($id);
        $order->update(['status' => 'cancelled']);

        if ($order->driver_id) {
            Driver::where('id', $order->driver_id)->update(['status' => 'available']);
        }

        return response()->json(['message' => '🚫 تم إلغاء الطلب']);
    }
}
