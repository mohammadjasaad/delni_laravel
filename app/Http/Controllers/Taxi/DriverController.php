<?php

namespace App\Http\Controllers\Taxi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaxiOrder;

class DriverController extends Controller
{
    public function chat($order_id)
    {
        $order = TaxiOrder::with('driver')->findOrFail($order_id);
        return view('taxi.chat', [
            'order' => $order
        ]);
    }
}
