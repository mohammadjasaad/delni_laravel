<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// 🚖 خريطة الطلب (Route عام خارج admin)
Route::get('/taxi/order-map', function (Request $request) {
    // مثال: ?start=36.2021,37.1343&end=36.2155,37.1590&start_label=من_موقعي&end_label=الوجهة
    $startStr = $request->query('start', '36.2021,37.1343');
    $endStr   = $request->query('end',   '36.2155,37.1590');

    [$sLat, $sLng] = array_map('floatval', explode(',', $startStr));
    [$eLat, $eLng] = array_map('floatval', explode(',', $endStr));

    $start = [
        'lat'   => $sLat,
        'lng'   => $sLng,
        'label' => $request->query('start_label', 'نقطة الانطلاق'),
    ];
    $end = [
        'lat'   => $eLat,
        'lng'   => $eLng,
        'label' => $request->query('end_label', 'نقطة الوصول'),
    ];

    return view('taxi.order-map', compact('start', 'end'));
})->name('taxi.order.map');
// 🔍 فحص: مسار بسيط من taxi_public
Route::get('/ping-public', fn() => 'pong-public');
