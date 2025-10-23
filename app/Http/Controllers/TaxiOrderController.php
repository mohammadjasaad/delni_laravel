<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\TaxiOrder;
use App\Models\TaxiMessage;

class TaxiOrderController extends Controller
{
    /**
     * 🚖 إنشاء طلب تاكسي وتخصيص أقرب سائق متاح
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|numeric',
            'pickup_latitude' => 'required|numeric',
            'pickup_longitude' => 'required|numeric',
        ]);

        $pickupLat = $request->pickup_latitude;
        $pickupLng = $request->pickup_longitude;

        // 🟡 جلب أقرب سائق متاح
        $driver = Driver::where('status', 'available')
            ->selectRaw(
                "*, (6371 * acos( cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)) )) AS distance",
                [$pickupLat, $pickupLng, $pickupLat]
            )
            ->orderBy('distance')
            ->first();

        if (!$driver) {
            return response()->json(['message' => '🚫 لا يوجد سائق متاح حالياً'], 404);
        }

        // 🟢 إنشاء الطلب
        $order = TaxiOrder::create([
            'user_id' => $request->user_id,
            'pickup_latitude' => $pickupLat,
            'pickup_longitude' => $pickupLng,
            'driver_id' => $driver->id,
            'status' => 'pending',
        ]);

        $driver->update(['status' => 'busy']);

        return redirect()->route('taxi.order.status', ['id' => $order->id])
            ->with('success', '✅ تم إرسال الطلب بنجاح، نعمل على توصيل السائق إليك.');
    }

    /**
     * 📍 عرض حالة الطلب (الصفحة التفاعلية)
     */
    public function showStatus($id)
    {
        $order = TaxiOrder::with('driver')->findOrFail($id);
        $driver = $order->driver;

        return view('taxi.order-status', compact('order', 'driver'));
    }

    /**
     * 🔄 تحديث حالة الطلب (للـ Realtime عبر AJAX)
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
                'id' => $order->driver->id,
                'name' => $order->driver->name,
                'car_model' => $order->driver->car_model,
                'car_number' => $order->driver->car_number,
                'phone' => $order->driver->phone,
                'latitude' => $order->driver->latitude,
                'longitude' => $order->driver->longitude,
            ] : null,
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
        return back()->with('success', '🚦 تم بدء الرحلة بنجاح.');
    }

    /**
     * ✅ إنهاء الرحلة
     */
    public function complete($id)
    {
        $order = TaxiOrder::findOrFail($id);
        $order->update(['status' => 'completed']);

        if ($order->driver_id) {
            $driver = Driver::find($order->driver_id);
            if ($driver) {
                $driver->update(['status' => 'available']);
            }
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
            $driver = Driver::find($order->driver_id);
            if ($driver) {
                $driver->update(['status' => 'available']);
            }
        }

        return response()->json(['message' => '🚫 تم إلغاء الطلب']);
    }

    /**
     * 🔄 تحديث حالة الطلب (من لوحة التحكم)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,completed,cancelled,ongoing'
        ]);

        $order = TaxiOrder::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return back()->with('success', '✅ تم تحديث حالة الطلب بنجاح');
    }

    /**
     * 📋 عرض جميع الطلبات + الرسائل (للوحة الإدارة)
     */
    public function index(Request $request)
    {
        $query = TaxiOrder::with(['driver', 'messages']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('driver')) {
            $query->whereHas('driver', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->driver . '%');
            });
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        $orders = $query->latest()->paginate(20)->appends($request->query());
        $messages = TaxiMessage::with('order')->latest()->get();

        return view('admin.taxi.orders', compact('orders', 'messages'));
    }
}
