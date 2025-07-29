<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaxiDriver;
use App\Models\TaxiOrder;

class TaxiDriverController extends Controller
{
    public function driverPanel()
    {
        // مؤقتًا: استخدام أول سائق في الجدول (لاحقًا نربطه بالسائق المسجل)
        $driver = TaxiDriver::first();

        if (!$driver) {
            return redirect()->route('home')->with('error', '⚠️ لا يوجد سائق في النظام بعد.');
        }

        // جلب الطلبات الجارية فقط
        $orders = TaxiOrder::where('driver_id', $driver->id)
            ->where('status', 'قيد التنفيذ')
            ->orderByDesc('created_at')
            ->get();

        return view('taxi.drivers.panel', compact('driver', 'orders'));
    }
}
