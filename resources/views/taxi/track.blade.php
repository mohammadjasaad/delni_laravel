<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>تتبّع الرحلة #{{ $orderId }}</title>

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="anonymous">
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin="anonymous"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  (['resources/css/app.css','resources/js/app.js'])<style> html,body{height:100%;margin:0} #map{height:calc(100vh - 64px);} </style>
</head>
<body class="bg-gray-50 text-gray-800">
  <div class="p-3 bg-white shadow flex flex-wrap items-center gap-3">
    <strong>🚖 تتبّع الرحلة:</strong> <span class="font-mono">#{{ $orderId }}</span>
    <span class="hidden sm:inline">•</span>
    <span>الحالة: <span id="status" class="font-semibold">—</span></span>
    <span class="hidden sm:inline">•</span>
    <span>آخر تحديث: <span id="updated" class="font-semibold">—</span></span>
  </div>
  <div id="map"></div>

  <script>
    const orderId = @json($orderId);
    const map = L.map('map').setView(34.8, 38.99], 6);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:19}).addTo(map);

    const drvIcon = L.icon({
      iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
      shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
      iconSize:[25,41], iconAnchor:[12,41], shadowSize:[41,41]
    });
    let driverMarker = null;

    const $status = document.getElementById('status');
    const $updated = document.getElementById('updated');
    const fmt = iso => { try { return iso ? new Date(iso).toLocaleString() : '—'; } catch{ return '—'; } };

    function place(lat,lng, status, updated_at){
      if (!Number.isFinite(lat) || !Number.isFinite(lng)) return;
      if (!driverMarker) {
        driverMarker = L.marker(lat,lng], {icon: drvIcon}).addTo(map);
        map.setView(lat,lng], 14);
      } else {
        driverMarker.setLatLng(lat,lng]);
      }
      driverMarker.bindPopup(`السائق هنا<br>(${lat.toFixed(5)}, ${lng.toFixed(5)})`).openPopup();
      if (status) $status.textContent = status;
      if (updated_at) $updated.textContent = fmt(updated_at);
    }

    // بث حي عبر قناة الطلب
    if (window.Echo) {
      window.Echo.channel(`driver.location.${orderId}`)
        .listen('.DriverStatusUpdated', (e) => {
          const lat = e.lat ?? e.latitude;
          const lng = e.lng ?? e.longitude;
          place(Number(lat), Number(lng), e.status, e.updated_at);
        });
    } else {
      console.warn('Echo غير مُفعّل، سيتم الاعتماد على البولنغ.');
    }

    // بولنغ احتياطي
    async function poll(){
      try{
        const res = await fetch(`/taxi/order/${orderId}/json`, {headers:{'Accept':'application/json'}, cache:'no-store'});
        if(!res.ok) throw new Error('HTTP '+res.status);
        const j = await res.json();
        const d = j.driver || {};
        const lat = d.latitude ?? d.lat;
        const lng = d.longitude ?? d.lon ?? d.lng;
        place(Number(lat), Number(lng), d.status, j.order?.updated_at);
      }catch(e){ /* ignore */ }
    }
    poll();
    setInterval(poll, 10000);
  </script>
</body>
</html>
