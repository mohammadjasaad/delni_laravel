<?php

namespace App\Http\Controllers\Taxi;

use App\Models\Driver;
use App\Models\TaxiOrder;
use App\Models\TaxiMessage;

class TaxiTestController extends Controller
{
    public function index()
    {
        // جلب جميع السائقين مع الطلبات
        $drivers = Driver::with('orders')->get();

        // جلب جميع الطلبات مع الرسائل
        $orders = TaxiOrder::with('messages')->get();

        // جلب جميع الرسائل مع الطلب المرتبط
        $messages = TaxiMessage::with('order')->get();

        return view('taxi.test', compact('drivers', 'orders', 'messages'));
    }
}
