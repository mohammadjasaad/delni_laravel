<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Driver;
use App\Models\TaxiMessage;

class DriverPanelController extends Controller
{
    public function index($driver_id)
    {
        $driver = Driver::findOrFail($driver_id);
        $order = Order::where('driver_id', $driver->id)->where('status', 'قيد التنفيذ')->first();
        return view('taxi.drivers.panel', compact('driver', 'order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $driver = Driver::findOrFail($id);
        $driver->status = $request->status;
        $driver->save();

        return back()->with('success', 'تم تحديث الحالة بنجاح');
    }

    public function updateLocation(Request $request, $id)
    {
        $driver = Driver::findOrFail($id);
        $driver->latitude = $request->lat;
        $driver->longitude = $request->lon;
        $driver->save();

        return response()->json(['status' => 'success']);
    }
}
