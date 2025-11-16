@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<style>#map{height:65vh;border-radius:16px}</style>
@endsection

@section('content')
<div class="max-w-5xl mx-auto py-6 px-4">
  <div class="flex items-center justify-between mb-3">
    <h2 class="text-xl font-semibold">طلب رقم #{{ $order->id }}</h2>
    <span class="px-3 py-1 rounded-full text-sm border">
      الحالة: <b id="status">{{ $order->status }}</b>
    </span>
  </div>
  <div id="map" class="mb-3"></div>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
    <div class="p-3 rounded-xl border">
      <div class="text-sm text-gray-500">المسافة</div>
      <div class="text-2xl font-bold">{{ number_format($order->distance_km,2) }} كم</div>
    </div>
    <div class="p-3 rounded-xl border">
      <div class="text-sm text-gray-500">التكلفة</div>
      <div class="text-2xl font-bold">{{ number_format($order->fare_syp) }} ل.س</div>
    </div>
    <div class="p-3 rounded-xl border">
      <div class="text-sm text-gray-500">السائق</div>
      <div class="text-lg font-semibold" id="driverName">{{ optional($order->driver)->name ?? '—' }}</div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const orderId = {{ $order->id }};
const pickup  = [{{ $order->pickup_lat }}, {{ $order->pickup_lng }}];
const dropoff = [{{ $order->dropoff_lat }}, {{ $order->dropoff_lng }}];

const map = L.map('map').setView(pickup, 13);
L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png',{
  attribution: '&copy; OpenStreetMap, &copy; CARTO'
}).addTo(map);

const pickupIcon  = L.circleMarker(pickup,  {radius:8, fillOpacity:1}).addTo(map).bindPopup('نقطة الانطلاق');
const dropoffIcon = L.circleMarker(dropoff, {radius:8, fillOpacity:1}).addTo(map).bindPopup('الوجهة');

let driverMarker = null;
let routeLine = null;

// اعرض المسار لو متوفر
@if($order->route_polyline)
  const poly = {!! $order->route_polyline !!};
  routeLine = L.polyline(poly, {weight:5, opacity:0.9}).addTo(map);
  map.fitBounds(routeLine.getBounds(), {padding:[30,30]});
@endif

// Laravel Echo (مفترض مهيّأ عندك)
@if (config('broadcasting.default') !== 'null')
window.Echo.channel('taxi-order.'+orderId)
  .listen('.TaxiLocationUpdated', (e) => {
      const latlng = [e.lat, e.lng];
      if (!driverMarker) {
        driverMarker = L.marker(latlng).addTo(map).bindPopup('السائق');
      } else {
        driverMarker.setLatLng(latlng);
      }
  })
  .listen('.TaxiOrderStatusChanged', (e) => {
      document.getElementById('status').textContent = e.order.status;
      if (e.order.driver && e.order.driver.name) {
        document.getElementById('driverName').textContent = e.order.driver.name;
      }
  });
@endif
</script>
@endsection
