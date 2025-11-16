@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css"/>
<style>
  #map { height: 68vh; border-radius: 16px; }
  .price-box { position: absolute; top: 12px; right: 12px; z-index: 1000; }
  .city-btn { @apply px-3 py-1 bg-white/90 rounded-full border text-sm hover:bg-white; }
</style>
@endsection

@section('content')
<div class="max-w-6xl mx-auto py-6 px-4">
  <h2 class="text-xl font-semibold mb-3">Delni Taxi — احجز رحلتك الآن</h2>

  {{-- مدن رئيسية --}}
  <div class="flex flex-wrap gap-2 mb-3">
    <button class="city-btn" data-lat="33.5138073" data-lng="36.2765279">دمشق</button>
    <button class="city-btn" data-lat="36.2062933" data-lng="37.1579641">حلب</button>
    <button class="city-btn" data-lat="34.730318"   data-lng="36.70964">حمص</button>
    <button class="city-btn" data-lat="35.51749"    data-lng="35.78152">اللاذقية</button>
    <button class="city-btn" data-lat="35.13178"    data-lng="36.75783">حماة</button>
    <button class="city-btn" data-lat="34.88902"    data-lng="35.88659">طرطوس</button>
  </div>

  <div class="relative">
    <div id="map"></div>
    <div class="price-box">
      <div class="bg-white rounded-xl shadow p-3 min-w-[220px]">
        <div class="text-xs text-gray-500 mb-1">التسعير المتوقع</div>
        <div class="text-2xl font-bold"><span id="fare">—</span> ل.س</div>
        <div class="text-xs text-gray-500 mt-1"><span id="distance">—</span> كم</div>
        <button id="confirmBtn" class="mt-3 w-full bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-4 py-2 rounded-lg disabled:opacity-50" disabled>تأكيد الطلب</button>
      </div>
    </div>
  </div>

  <p class="text-sm text-gray-500 mt-3">
    حدد نقطة الانطلاق ثم الوجهة على الخريطة. سنحسب المسافة والسعر بالليرة السورية وفق تعرفة Delni.
  </p>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
<script>
(function(){
  // خريطة داكنة مثل Uber
  const map = L.map('map', { zoomControl: false }).setView([33.5138, 36.2765], 13);
  L.control.zoom({ position: 'bottomright' }).addTo(map);

  L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
    attribution: '&copy; OpenStreetMap, &copy; CARTO'
  }).addTo(map);

  // زر مدن
  document.querySelectorAll('.city-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const lat = parseFloat(btn.dataset.lat);
      const lng = parseFloat(btn.dataset.lng);
      map.setView([lat, lng], 13);
    });
  });

  // نقاط الالتقاط والوجهة
  let pickupMarker = null, dropoffMarker = null, routeControl = null;
  let distanceKm = 0;

  map.on('click', (e) => {
    if (!pickupMarker) {
      pickupMarker = L.marker(e.latlng, { draggable: true }).addTo(map).bindPopup('نقطة الانطلاق').openPopup();
      pickupMarker.on('dragend', drawRoute);
    } else if (!dropoffMarker) {
      dropoffMarker = L.marker(e.latlng, { draggable: true }).addTo(map).bindPopup('الوجهة').openPopup();
      dropoffMarker.on('dragend', drawRoute);
      drawRoute();
    } else {
      // إعادة اختيار
      if (dropoffMarker) { map.removeLayer(dropoffMarker); dropoffMarker = null; }
      if (pickupMarker)  { map.removeLayer(pickupMarker);  pickupMarker  = null; }
      if (routeControl)  { map.removeControl(routeControl); routeControl = null; }
      document.getElementById('fare').textContent = '—';
      document.getElementById('distance').textContent = '—';
      document.getElementById('confirmBtn').disabled = true;
    }
  });

  function drawRoute(){
    if (!pickupMarker || !dropoffMarker) return;
    if (routeControl) { map.removeControl(routeControl); routeControl = null; }

    routeControl = L.Routing.control({
      waypoints: [
        L.latLng(pickupMarker.getLatLng().lat, pickupMarker.getLatLng().lng),
        L.latLng(dropoffMarker.getLatLng().lat, dropoffMarker.getLatLng().lng)
      ],
      lineOptions: { addWaypoints: false },
      show: false,
      routeWhileDragging: false,
      router: L.Routing.osrmv1({ serviceUrl: 'https://router.project-osrm.org/route/v1' }),
    })
    .on('routesfound', async function(e){
      const route = e.routes[0];
      distanceKm = (route.summary.totalDistance / 1000).toFixed(2);
      document.getElementById('distance').textContent = distanceKm;

      // طلب تسعير من السيرفر (مع القيم المحدثة من config/taxi.php)
      try {
        const resp = await fetch('{{ route('api.taxi.quote') }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({ distance_km: distanceKm })
        });
        const data = await resp.json();
        document.getElementById('fare').textContent = data.fare_syp?.toLocaleString('ar-SY') ?? '—';
        document.getElementById('confirmBtn').disabled = false;
        // خزّن polyline (GeoJSON-like)
        route._poly = route.coordinates.map(c => [c.lat, c.lng]);
      } catch (err) {
        console.error(err);
      }
    })
    .addTo(map);
  }

  // تأكيد الطلب
  document.getElementById('confirmBtn').addEventListener('click', async () => {
    if (!pickupMarker || !dropoffMarker || !routeControl) return;

    const pickup  = pickupMarker.getLatLng();
    const dropoff = dropoffMarker.getLatLng();

    // استخرج polyline من آخر Route
    const routes = routeControl._routes || [];
    let poly = null;
    if (routes.length) {
      const r = routes[0];
      poly = r._poly ? JSON.stringify(r._poly) : null;
    }

    const payload = {
      pickup_lat:  pickup.lat,
      pickup_lng:  pickup.lng,
      dropoff_lat: dropoff.lat,
      dropoff_lng: dropoff.lng,
      distance_km: distanceKm,
      route_polyline: poly
    };

    try {
      const resp = await fetch('{{ route('api.taxi.orders.store') }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(payload)
      });
      const data = await resp.json();
      if (data.ok) {
        window.location.href = "{{ url('/taxi/order') }}/" + data.order.id;
      }
    } catch (e) {
      console.error(e);
    }
  });

})();
</script>
@endsection
