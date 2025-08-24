<?php

return [

    // السعر الأساسي
    'base_fare' => env('TAXI_BASE_FARE', 30),

    // السعر لكل كيلومتر
    'per_km' => env('TAXI_PER_KM', 8),

    // السعر لكل دقيقة
    'per_min' => env('TAXI_PER_MIN', 0),

    // أقل سعر للرحلة
    'min_fare' => env('TAXI_MIN_FARE', 35),

    // نسبة الزيادة (Surge Pricing)
    'surge' => env('TAXI_SURGE', 1.0),

];
