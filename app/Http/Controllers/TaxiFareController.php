<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaxiFareController extends Controller
{
    public function calculate(Request $request)
    {
        // جلب البيانات من الطلب
        $distance_m = $request->input('estimated_distance_m', 0);
        $duration_s = $request->input('estimated_duration_s', 0);

        // جلب القيم من env أو وضع افتراضية
        $baseFare = env('TAXI_BASE_FARE', 30); // سعر فتح العداد
        $perKm = env('TAXI_PER_KM', 8);        // سعر الكيلومتر
        $perMin = env('TAXI_PER_MIN', 0);      // سعر الدقيقة
        $minFare = env('TAXI_MIN_FARE', 35);   // الحد الأدنى للأجرة
        $surge = env('TAXI_SURGE', 1.0);       // معامل الزيادة

        // التحويل من متر إلى كم ومن ثانية إلى دقيقة
        $distance_km = $distance_m / 1000;
        $duration_min = $duration_s / 60;

        // حساب السعر
        $fare = $baseFare + ($distance_km * $perKm) + ($duration_min * $perMin);

        // تطبيق معامل الزيادة
        $fare = $fare * $surge;

        // التأكد من الحد الأدنى
        if ($fare < $minFare) {
            $fare = $minFare;
        }

        return response()->json([
            'fare' => round($fare)
        ]);
    }
}
