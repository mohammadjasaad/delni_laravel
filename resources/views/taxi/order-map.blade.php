<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>خريطة الطلب</title>

  <!-- Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="anonymous">
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
          integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="anonymous"></script>

  <style>
    html, body { height: 100%; margin: 0; font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif; }
    .page { height: 100%; display: grid; grid-template-rows: auto 1fr; }
    .toolbar {
      display:flex; gap:.5rem; align-items:center; padding:.75rem 1rem; background:#f7f7f7; border-bottom:1px solid #e5e7eb;
      flex-wrap:wrap;
    }
    .toolbar input { padding:.45rem .6rem; border:1px solid #d1d5db; border-radius:.5rem; min-width: 13rem; }
    .toolbar button { padding:.5rem .8rem; border:0; border-radius:.6rem; cursor:pointer; background:#111827; color:#fff; }
    .toolbar .ghost { background:#e5e7eb; color:#111827; }
    #map { width: 100%; height: calc(100vh - 62px); }
    .badge { display:inline-block; padding:.2rem .5rem; border-radius:999px; font-size:.8rem; color:#fff; }
    .badge-start { background:#10b981; }
    .badge-end { background:#ef4444; }
  </style>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <script>
    // ===== Pricing config from .env (with defaults) =====
    const PRICING = {
      baseFare: @json((float) env('TAXI_BASE_FARE', 25)),
      perKm: @json((float) env('TAXI_PER_KM', 9)),
      perMin: @json((float) env('TAXI_PER_MIN', 1.2)),
      minimumFare: @json((float) env('TAXI_MIN_FARE', 35)),
      surge: @json((float) env('TAXI_SURGE', 1.0)),
    };
  </script>
</head>
<body>
<div class="page">
  <div class="toolbar">
    <span class="badge badge-start">انطلاق</span>
    <input id="startLabel" placeholder="تسمية الانطلاق" />
    <input id="startCoord" placeholder="lat,lng" />

    <button id="swapBtn" class="ghost" title="تبديل الانطلاق/الوصول">تبديل ↔</button>

    <span class="badge badge-end">وصول</span>
    <input id="endLabel" placeholder="تسمية الوصول" />
    <input id="endCoord" placeholder="lat,lng" />

    <button id="copyBtn" title="نسخ رابط بنفس الإحداثيات">نسخ الرابط</button>

    <!-- زر موقعي الآن -->
    <button id="myLocationBtn" class="ghost" title="تحديد موقعي الآن">📍 موقعي الآن</button>

    <!-- معلومات المسافة/المدة -->
    <span id="infoBox" style="margin-inline-start:.75rem;font-weight:600"></span>
    <!-- السعر التقديري -->
    <span id="fareBox" style="margin-inline-start:.5rem;font-weight:700;color:#b45309"></span>

    <!-- حالة الرحلة -->
    <button id="startTripBtn" class="ghost">بدء الرحلة</button>
    <button id="endTripBtn" class="ghost" disabled>إنهاء الرحلة</button>

    <!-- حفظ الطلب -->
    <button id="saveOrderBtn">حفظ الطلب</button>
  </div>
  <div id="map"></div>
</div>

<script>
  // -------- Helpers --------
  function qs(name, def="") {
    const p = new URLSearchParams(location.search);
    return p.get(name) ?? def;
  }
  function parseLatLng(s, fallback) {
    try {
      const [lat, lng] = (s || "").split(",").map(Number);
      if (Number.isFinite(lat) && Number.isFinite(lng)) return [lat, lng];
    } catch {}
    return fallback;
  }
  function setInputs(start, end, startLabel, endLabel) {
    document.getElementById('startCoord').value = start.join(',');
    document.getElementById('endCoord').value   = end.join(',');
    document.getElementById('startLabel').value = startLabel;
    document.getElementById('endLabel').value   = endLabel;
  }
  function updateUrl(start, end, startLabel, endLabel) {
    const u = new URL(location.href);
    const sp = u.searchParams;
    sp.set('start', start.join(','));
    sp.set('end',   end.join(','));
    sp.set('start_label', startLabel || 'نقطة الانطلاق');
    sp.set('end_label',   endLabel   || 'نقطة الوصول');
    history.replaceState(null, '', u.toString());
  }

  function calcFare(km, min) {
    if (!Number.isFinite(km)) km = 0;
    if (!Number.isFinite(min)) min = 0;
    let fare = PRICING.baseFare + (km * PRICING.perKm) + (min * PRICING.perMin);
    fare = fare * (PRICING.surge || 1.0);
    if (fare < PRICING.minimumFare) fare = PRICING.minimumFare;
    return Math.round(fare);
  }
  function renderFare(km, min) {
    const fareSpan = document.getElementById('fareBox');
    if (!fareSpan) return null;
    const fare = calcFare(km, min);
    fareSpan.textContent = `• السعر التقديري: ${fare} ₺`;
    return fare;
  }

  // -------- Initial values from server or query params --------
  const serverStart = [{{ $start['lat'] ?? '36.2021' }}, {{ $start['lng'] ?? '37.1343' }}];
  const serverEnd   = [{{ $end['lat'] ?? '36.2155' }}, {{ $end['lng'] ?? '37.1590' }}];
  const start = parseLatLng(qs('start'), serverStart);
  const end   = parseLatLng(qs('end'),   serverEnd);
  const startLabel = qs('start_label', @json($start['label'] ?? 'نقطة الانطلاق'));
  const endLabel   = qs('end_label',   @json($end['label'] ?? 'نقطة الوصول'));

  setInputs(start, end, startLabel, endLabel);

  // -------- Map --------
  const map = L.map('map', { zoomControl: true }).setView((start[0]+end[0])/2, (start[1]+end[1])/2], 14);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 20, attribution: '&copy; OpenStreetMap'
  }).addTo(map);

  // Colored marker icons
  const iconGreen = L.icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
    iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34],
    shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png', shadowSize: [41, 41]
  });
  const iconRed = L.icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
    iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34],
    shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png', shadowSize: [41, 41]
  });

  const startMarker = L.marker(start, { draggable: true, icon: iconGreen }).addTo(map)
    .bindPopup(`<b>انطلاق:</b> ${startLabel}`);
  const endMarker   = L.marker(end,   { draggable: true, icon: iconRed   }).addTo(map)
    .bindPopup(`<b>وصول:</b> ${endLabel}`);

  const group = L.featureGroup(startMarker, endMarker]).addTo(map);
  map.fitBounds(group.getBounds().pad(0.3));

  // خط مستقيم بين النقطتين (مرئي دائمًا)
  let line = L.polyline(startMarker.getLatLng(), endMarker.getLatLng()], { weight: 3 }).addTo(map);

  function refreshState() {
    const sLL = startMarker.getLatLng();
    const eLL = endMarker.getLatLng();
    const s = [+(sLL.lat.toFixed(6)), +(sLL.lng.toFixed(6))];
    const e = [+(eLL.lat.toFixed(6)), +(eLL.lng.toFixed(6))];
    const sLabel = document.getElementById('startLabel').value || 'نقطة الانطلاق';
    const eLabel = document.getElementById('endLabel').value   || 'نقطة الوصول';
    setInputs(s, e, sLabel, eLabel);
    updateUrl(s, e, sLabel, eLabel);
    startMarker.setPopupContent(`<b>انطلاق:</b> ${sLabel}`);
    endMarker.setPopupContent(`<b>وصول:</b> ${eLabel}`);
    line.setLatLngs(s, e]);
  }

  startMarker.on('dragend', refreshState);
  endMarker.on('dragend', refreshState);

  // Swap button
  document.getElementById('swapBtn').addEventListener('click', () => {
    const sLL = startMarker.getLatLng();
    const eLL = endMarker.getLatLng();
    const sLabel = document.getElementById('startLabel').value;
    const eLabel = document.getElementById('endLabel').value;

    startMarker.setLatLng(eLL);
    endMarker.setLatLng(sLL);

    document.getElementById('startLabel').value = eLabel;
    document.getElementById('endLabel').value   = sLabel;

    refreshState();
  });

  // Copy URL button
  document.getElementById('copyBtn').addEventListener('click', async () => {
    try {
      await navigator.clipboard.writeText(location.href);
      const btn = document.getElementById('copyBtn');
      const old = btn.textContent;
      btn.textContent = 'تم النسخ ✓';
      setTimeout(() => btn.textContent = old, 1200);
    } catch(e) { alert('لم يتم النسخ تلقائيًا—انسخ الرابط يدويًا.'); }
  });

  // Manual edits
  ['startCoord','endCoord','startLabel','endLabel'].forEach(id => {
    document.getElementById(id).addEventListener('change', () => {
      const s = parseLatLng(document.getElementById('startCoord').value, [startMarker.getLatLng().lat, startMarker.getLatLng().lng]);
      const e = parseLatLng(document.getElementById('endCoord').value,   [endMarker.getLatLng().lat, endMarker.getLatLng().lng]);
      startMarker.setLatLng(s);
      endMarker.setLatLng(e);
      refreshState();
    });
  });

  // Apply initial URL
  refreshState();

  // -------- OSRM routing (with fallback) --------
  let routeLine = null;
  async function updateRouteAndStats() {
    const s = startMarker.getLatLng();
    const e = endMarker.getLatLng();
    const url = `https://router.project-osrm.org/route/v1/driving/${s.lng},${s.lat};${e.lng},${e.lat}?overview=full&geometries=geojson`;
    try {
      const res = await fetch(url, { cache: 'no-store' });
      if (!res.ok) throw new Error('osrm http');
      const data = await res.json();
      const route = data?.routes?.[0];
      if (!route) throw new Error('no route');

      const meters = route.distance;
      const seconds = route.duration;
      const km = +(meters / 1000).toFixed(2);
      const min = Math.round(seconds / 60);

      if (routeLine) map.removeLayer(routeLine);
      routeLine = L.geoJSON(route.geometry, { weight: 4, opacity: .8 }).addTo(map);

      document.getElementById('infoBox').textContent = `المسافة: ${km} كم • المدة: ~ ${min} دقيقة`;
      renderFare(km, min);
      return { km, min };
    } catch (_) {
      // Haversine fallback
      const R = 6371; // km
      const d2r = (d)=>d*Math.PI/180;
      const dLat = d2r(e.lat - s.lat);
      const dLng = d2r(e.lng - s.lng);
      const a = Math.sin(dLat/2)**2 + Math.cos(d2r(s.lat))*Math.cos(d2r(e.lat))*Math.sin(dLng/2)**2;
      const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
      const km = +((R * c).toFixed(2));
      const min = Math.round((km / 35) * 60); // تقدير داخل المدينة
      if (routeLine) { map.removeLayer(routeLine); routeLine=null; }
      document.getElementById('infoBox').textContent = `المسافة (تقديري): ${km} كم • المدة: ~ ${min} دقيقة`;
      renderFare(km, min);
      return { km, min };
    }
  }

  // Hook OSRM into refresh
  const _oldRefresh = refreshState;
  refreshState = async function() {
    _oldRefresh();
    await updateRouteAndStats();
  };
  updateRouteAndStats();

  // -------- Trip state --------
  let tripStartedAt = null;
  document.getElementById('startTripBtn').addEventListener('click', () => {
    tripStartedAt = new Date();
    document.getElementById('startTripBtn').disabled = true;
    document.getElementById('endTripBtn').disabled = false;
  });

  document.getElementById('endTripBtn').addEventListener('click', () => {
    if (!tripStartedAt) return;
    const diffMin = Math.max(1, Math.round((Date.now() - tripStartedAt.getTime()) / 60000));
    alert(`تم إنهاء الرحلة. الزمن الفعلي: ~ ${diffMin} دقيقة.`);
    document.getElementById('endTripBtn').disabled = true;
  });

  // -------- 📍 زر موقعي الآن --------
  document.getElementById('myLocationBtn').addEventListener('click', () => {
    if (!navigator.geolocation) {
      alert('متصفحك لا يدعم تحديد الموقع.');
      return;
    }
    navigator.geolocation.getCurrentPosition(async (pos) => {
      const lat = pos.coords.latitude;
      const lng = pos.coords.longitude;
      startMarker.setLatLng(lat, lng]);
      refreshState();
      await updateRouteAndStats();
    }, (err) => {
      alert('تعذّر تحديد الموقع: ' + err.message);
    }, { enableHighAccuracy: true, timeout: 10000 });
  });

  // -------- Save to DB (AJAX) --------
  async function saveOrder() {
    const sLL = startMarker.getLatLng();
    const eLL = endMarker.getLatLng();
    const sLabel = document.getElementById('startLabel').value || 'نقطة الانطلاق';
    const eLabel = document.getElementById('endLabel').value || 'نقطة الوصول';
    const stats = await updateRouteAndStats();
    const estimatedFare = renderFare(stats?.km ?? 0, stats?.min ?? 0) ?? null;
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    const payload = {
      pickup_lat: sLL.lat, pickup_lng: sLL.lng, pickup_label: sLabel,
      dropoff_lat: eLL.lat, dropoff_lng: eLL.lng, dropoff_label: eLabel,
      distance_km: stats?.km ?? null, duration_min: stats?.min ?? null,
      estimated_fare: estimatedFare
    };

    const res = await fetch("{{ route('taxi.order.saveFromMap') }}", {
      method: 'POST',
      headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': token },
      body: JSON.stringify(payload)
    });

    if (res.ok) {
      const data = await res.json().catch(()=>({}));
      alert('تم حفظ الطلب بنجاح' + (data?.id ? ` (ID: ${data.id})` : ''));
      if (data?.redirect_url) {
        location.href = data.redirect_url; // تحويل لصفحة حالة الطلب
      }
    } else {
      const t = await res.text();
      alert('تعذّر الحفظ: ' + t);
    }
  }
  document.getElementById('saveOrderBtn').addEventListener('click', saveOrder);
</script>
</body>
</html>
