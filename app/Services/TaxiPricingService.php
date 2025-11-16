<?php

namespace App\Services;

class TaxiPricingService
{
    /**
     * حساب السعر بالليرة السورية
     * تسعيرة Uber Style
     *
     * - حد أدنى: 8,000 ل.س
     * - فتح عداد: 3,000 ل.س
     * - لكل 1 كم: 1,200 ل.س
     */
    public function quote($distanceKm): int
    {
        $baseFare = 3000;
        $perKm = 1200;
        $minFare = 8000;

        $distanceFare = $baseFare + ($distanceKm * $perKm);
        return max($minFare, intval(round($distanceFare)));
    }
}
