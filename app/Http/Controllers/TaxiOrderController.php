<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaxiDriver;
use App\Models\TaxiOrder;
use App\Models\Rating;

class TaxiOrderController extends Controller
{
    /**
     * 🚖 إنشاء طلب تاكسي وتخصيص أقرب سائق متاح
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string',
            'pickup_latitude' => 'required|numeric',
            'pickup_longitude' => 'required|numeric',
        ]);

        $pickupLat = $request->pickup_latitude;
        $pickupLng = $request->pickup_longitude;

        $driver = TaxiDriver::where('status', 'متاح')
            ->selectRaw(
                "*, (6371 * acos( cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)) )) AS distance",
                [$pickupLat, $pickupLng, $pickupLat]
            )
            ->orderBy('distance')
            ->first();

        if (!$driver) {
            return response()->json(['message' => 'لا يوجد سائق متاح حاليًا'], 404);
        }

        $order = TaxiOrder::create([
            'user_name' => $request->user_name,
            'pickup_latitude' => $pickupLat,
            'pickup_longitude' => $pickupLng,
            'driver_id' => $driver->id,
            'status' => 'قيد التنفيذ',
        ]);

        $driver->update(['status' => 'مشغول']);

        return response()->json([
            'message' => 'تم إرسال الطلب بنجاح',
            'order_id' => $order->id,
            'order' => $order,
            'driver' => $driver,
        ]);
    }

    /**
     * 🚦 بدء الرحلة من قبل السائق
     */
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

    /**
     * 📍 عرض حالة الطلب والخريطة والمحادثة
     */
    public function showStatus($id)
    {
        $order = TaxiOrder::findOrFail($id);
        $driver = TaxiDriver::find($order->driver_id);

        return view('taxi.order-status', compact('order', 'driver'));
    }

    /**
     * ✅ إنهاء الرحلة وإعادة تعيين السائق
     */
    public function complete($id)
    {
        $order = TaxiOrder::findOrFail($id);
        $order->update(['status' => 'منتهي']);

        if ($order->driver_id) {
            $driver = TaxiDriver::find($order->driver_id);
            if ($driver) {
                $driver->update(['status' => 'متاح']);
            }
        }

        return response()->json(['message' => 'تم إنهاء الرحلة بنجاح']);
    }

    /**
     * ⭐ إنهاء الرحلة مع تقييم السائق
     */
    public function completeWithRating(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:taxi_orders,id',
            'driver_id' => 'required|exists:taxi_drivers,id',
            'driver_name' => 'required|string',
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $order = TaxiOrder::findOrFail($request->order_id);
        $order->update(['status' => 'منتهي']);

        $driver = TaxiDriver::find($request->driver_id);
        if ($driver) {
            $driver->update(['status' => 'متاح']);
        }

        Rating::create([
            'driver_name' => $request->driver_name,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('trip.completed')->with('success', '✅ تم إنهاء الرحلة وتسجيل التقييم.');
    }

    /**
     * ❌ إلغاء الطلب واسترجاع السائق
     */
    public function cancel($id)
    {
        $order = TaxiOrder::findOrFail($id);
        $order->update(['status' => 'ملغي']);

        if ($order->driver_id) {
            $driver = TaxiDriver::find($order->driver_id);
            if ($driver) {
                $driver->update(['status' => 'متاح']);
            }
        }

        return response()->json(['message' => 'تم إلغاء الطلب']);
    }
}

