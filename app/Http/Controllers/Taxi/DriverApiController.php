<?php

namespace App\Http\Controllers\Taxi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;

class DriverApiController extends Controller
{
    // ✅ السائق يرسل موقعه من التطبيق
    public function updateLocation(Request $request, $id)
    {
        $driver = Driver::find($id);

        if (!$driver) {
            return response()->json(['error' => 'Driver not found'], 404);
        }

        $driver->update([
            'latitude' => $request->lat,
            'longitude' => $request->lng,
            'status' => 'available',
        ]);

        return response()->json(['status' => 'success']);
    }

    // ✅ جلب جميع السائقين للخرائط في التطبيق
    public function drivers()
    {
        return Driver::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->where('status', '!=', 'offline')
            ->get();
    }
}
