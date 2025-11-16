<?php

namespace App\Http\Controllers;

use App\Events\TaxiLocationUpdated;
use App\Events\TaxiOrderStatusChanged;
use App\Models\Driver;
use App\Models\TaxiOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaxiDriverController extends Controller
{
    // ربط سائق بأقرب طلب (أو تخصيص يدوي لديك)
    public function assignToOrder(Request $req, TaxiOrder $order)
    {
        $driver = Driver::findOrFail(session('driver_id')); // اعتمادًا على جلسة السائق لديك
        $order->update(['driver_id' => $driver->id, 'status' => 'assigned']);
        TaxiOrderStatusChanged::dispatch($order);

        return response()->json(['ok' => true, 'order' => $order]);
    }

    // تحديث الموقع اللحظي
    public function updateLocation(Request $req, TaxiOrder $order)
    {
        $lat = (float) $req->get('lat');
        $lng = (float) $req->get('lng');

        // خزّن الموقع في driver إذا رغبت
        $driverId = session('driver_id');
        TaxiLocationUpdated::dispatch($order->id, $lat, $lng, $driverId);

        return response()->json(['ok' => true]);
    }
}
