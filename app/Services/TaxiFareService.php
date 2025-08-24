<?php

namespace App\Services;

class TaxiFareService
{
    /**
     * حساب تكلفة الرحلة
     *
     * @param float $distanceKm المسافة بالكيلومترات
     * @param float $durationMin الزمن بالدقائق
     * @return float السعر النهائي
     */
    public function calculateFare(float $distanceKm, float $durationMin): float
    {
        $baseFare   = config('taxi.base_fare');
        $perKm      = config('taxi.per_km');
        $perMin     = config('taxi.per_min');
        $minFare    = config('taxi.min_fare');
        $surge      = config('taxi.surge');

        // حساب السعر
        $fare = $baseFare + ($distanceKm * $perKm) + ($durationMin * $perMin);

        // تطبيق أقل سعر إذا كان المجموع أقل
        if ($fare < $minFare) {
            $fare = $minFare;
        }

        // تطبيق نسبة الزيادة
        $fare *= $surge;

        return round($fare, 2); // تقريب السعر إلى خانتين عشريتين
    }
}
