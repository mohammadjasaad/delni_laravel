@extends('layouts.app')

@section('content')
<style>
    #map { height: calc(100vh - 160px); }
    .bottom-panel {
        position: fixed; bottom: 0; left: 0; right: 0;
        background: #fff; padding: 16px; border-radius: 18px 18px 0 0;
        box-shadow: 0 -4px 12px rgba(0,0,0,0.15);
    }
    .btn-main {
        background: #facc15; /* أصفر دلني */
        padding: 12px; font-weight: bold; border-radius: 10px;
    }
</style>

<div id="map"></div>

<div class="bottom-panel">
    <div class="flex items-center gap-3 mb-3">
        <img src="{{ asset('images/driver-avatar.png') }}" class="w-14 h-14 rounded-full border" alt="">
        <div class="flex-1">
            <div class="text-lg font-bold">🚖 {{ $driver->name }}</div>
            <div class="text-gray-600 text-sm">{{ $driver->car_model }} - {{ $driver->car_number }}</div>
        </div>
        <a href="tel:{{ $driver->phone }}" class="text-blue-600 text-xl font-bold">📞 اتصال</a>
    </div>

    <div class="flex justify-between text-center mb-4">
        <div>
            <div class="text-sm text-gray-600">المسافة</div>
            <div class="text-lg font-bold" id="distanceBox">—</div>
        </div>
        <div>
            <div class="text-sm text-gray-600">الوقت التقريبي</div>
            <div class="text-lg font-bold" id="etaBox">—</div>
        </div>
        <div>
            <div class="text-sm text-gray-600">الأجرة</div>
            <div class="text-lg font-bold">{{ number_format($order->fare_syp) }} ل.س</div>
        </div>
    </div>

    <a href="{{ route('taxi.chat', $order->id) }}" class="btn-main text-center block">💬 محادثة مع السائق</a>
</div>


<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.rotatedmarker/0.2.0/leaflet.rotatedMarker.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>

<script>
var map = L.map('map').setView([{{ $driver->latitude }}, {{ $driver->longitude }}], 15);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 22 }).addTo(map);

// ✅ السيارة
var carIcon = L.icon({
    iconUrl: "{{ asset('images/car.png') }}",
    iconSize: [50, 50],
    iconAnchor: [25, 25],
});
var carMarker = L.marker([{{ $driver->latitude }}, {{ $driver->longitude }}], {icon: carIcon}).addTo(map);

// ✅ استماع للتحديث اللحظي
window.Echo.channel('taxi-driver.{{ $driver->id }}')
.listen('.location.updated', (e) => {

    let lat = parseFloat(e.driver.latitude);
    let lng = parseFloat(e.driver.longitude);
    let newPos = L.latLng(lat, lng);

    // حساب زاوية الاتجاه
    var oldPos = carMarker.getLatLng();
    var angle = Math.atan2(newPos.lng - oldPos.lng, newPos.lat - oldPos.lat) * 180 / Math.PI;

    // تحديث الموقع والدوران
    carMarker.setLatLng(newPos);
    carMarker.setRotationAngle(angle);

    map.panTo(newPos);

    // ✅ حساب المسافة والوقت التقريبي بالدقائق
    var distance = map.distance(oldPos, newPos) / 1000; // km
    document.getElementById('distanceBox').innerHTML = distance.toFixed(2) + " كم";

    var eta = (distance / 0.6) * 60; // سرعة 35 كم/س
    document.getElementById('etaBox').innerHTML = Math.round(eta) + " دقيقة";
});
</script>
@endsection
