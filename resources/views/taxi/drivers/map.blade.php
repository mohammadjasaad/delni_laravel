<x-app-layout>
  <div class="max-w-7xl mx-auto px-4 py-8" dir="rtl">
    <h2 class="text-3xl font-bold text-center text-yellow-600 mb-6">
      🗺️ {{ __('messages.drivers_map') ?? 'خريطة السائقين التفاعلية' }}
    </h2>

    <style>#map{min-height:600px}</style>

    <!-- أدوات التحكم -->
    <div class="bg-white rounded-lg shadow p-4 mb-4 flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
      <div class="flex flex-wrap items-center gap-3">
        <label class="text-sm text-gray-700">فلترة الحالة:</label>
        <select id="statusFilter" class="border rounded px-3 py-2 text-sm">
          <option value="">الكل</option>
          <option value="متاح">متاح</option>
          <option value="مشغول">مشغول</option>
          <option value="خارج الخدمة">خارج الخدمة</option>
          <option value="غير متصل">غير متصل</option>
        </select>
        <button id="applyFilterBtn" class="px-4 py-2 rounded bg-yellow-500 text-white text-sm">تطبيق الفلترة</button>
        <button id="clearFilterBtn" class="px-4 py-2 rounded bg-gray-100 text-gray-800 text-sm">إلغاء الفلترة</button>

        <label class="inline-flex items-center gap-2 text-sm ms-2">
          <input id="withinBounds" type="checkbox" class="rounded">
          عرض فقط داخل حدود الخريطة
        </label>
      </div>

      <div class="flex flex-wrap items-center gap-3">
        <button id="locateBtn" class="px-4 py-2 rounded bg-gray-100 text-gray-800 text-sm">📍 حدّد موقعي</button>
        <button id="fitBtn" class="px-4 py-2 rounded bg-gray-100 text-gray-800 text-sm">🔎 ملاءمة للخريطة</button>

        <label class="inline-flex items-center gap-2 text-sm">
          <input id="autoRefresh" type="checkbox" class="rounded">
          تحديث تلقائي كل 10 ثوانٍ
        </label>

        <button id="refreshBtn" class="px-4 py-2 rounded bg-yellow-500 text-white text-sm">تحديث الآن</button>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow p-3 mb-3 text-sm text-gray-700 flex flex-wrap items-center gap-3">
      <span>آخر تحديث: <span id="lastUpdated" class="font-semibold">—</span></span>
      <span class="hidden sm:inline">•</span>
      <span>عدد السائقين المعروضين: <span id="driversCount" class="font-semibold">0</span></span>

      <div class="flex items-center gap-4 ms-auto">
        <span class="flex items-center gap-1"><span class="inline-block w-3 h-3 rounded-full" style="background:#22c55e"></span>متاح</span>
        <span class="flex items-center gap-1"><span class="inline-block w-3 h-3 rounded-full" style="background:#f59e0b"></span>مشغول</span>
        <span class="flex items-center gap-1"><span class="inline-block w-3 h-3 rounded-full" style="background:#ef4444"></span>خارج الخدمة</span>
        <span class="flex items-center gap-1"><span class="inline-block w-3 h-3 rounded-full" style="background:#6b7280"></span>غير متصل</span>
      </div>
    </div>

    <div id="map" class="w-full h-[600px] rounded-lg shadow overflow-hidden"></div>
  </div>

  <!-- Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="anonymous">
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin="anonymous"></script>

  @verbatim
  <script>
  document.addEventListener('DOMContentLoaded', function () {
    const map = L.map('map', { scrollWheelZoom: true }).setView(41.0082, 28.9784], 11);

    const invalidateSafe = () => { try { map.invalidateSize(true); } catch(_){} };
    setTimeout(invalidateSafe, 0);
    setTimeout(invalidateSafe, 300);
    setTimeout(invalidateSafe, 1000);
    window.addEventListener('load', invalidateSafe);
    window.addEventListener('resize', invalidateSafe);
    window.addEventListener('orientationchange', invalidateSafe);
    new ResizeObserver(invalidateSafe).observe(document.getElementById('map'));

    const tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19, attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
    tiles.on('load', invalidateSafe);

    const markersLayer = L.layerGroup().addTo(map);
    const markersById   = new Map();
    const statusColors  = { 'متاح':'#22c55e','مشغول':'#f59e0b','خارج الخدمة':'#ef4444','غير متصل':'#6b7280' };

    const statusFilter = document.getElementById('statusFilter');
    const withinBounds = document.getElementById('withinBounds');
    const applyFilterBtn = document.getElementById('applyFilterBtn');
    const clearFilterBtn = document.getElementById('clearFilterBtn');
    const locateBtn = document.getElementById('locateBtn');
    const fitBtn = document.getElementById('fitBtn');
    const refreshBtn = document.getElementById('refreshBtn');
    const autoRefresh = document.getElementById('autoRefresh');
    const lastUpdated = document.getElementById('lastUpdated');
    const driversCount = document.getElementById('driversCount');

    let autoTimer = null, firstLoadFit = true, lastBounds = null;
    const fmtTime = iso => { try { return iso ? new Date(iso).toLocaleString() : '—'; } catch { return '—'; } };
    const normalizeDriver = d => {
      const lat = d.lat ?? d.latitude ?? null;
      const lng = d.lng ?? d.lon ?? d.longitude ?? null;
      return { id:d.id, name:d.name, car_number:d.car_number, status:d.status ?? 'غير معروف',
               lat: typeof lat==='string'?parseFloat(lat):lat,
               lng: typeof lng==='string'?parseFloat(lng):lng,
               updated_at: d.updated_at ?? d.last_update ?? null };
    };

    async function fetchDrivers(){
      const params = new URLSearchParams();
      if (statusFilter.value) params.set('status', statusFilter.value);
      if (withinBounds.checked) {
        const b = map.getBounds();
        params.set('bounds', [b.getSouth(), b.getWest(), b.getNorth(), b.getEast()].map(v => +v.toFixed(6)).join(','));
      }
      params.set('limit','200');

      try{
        const res = await fetch(`/api/drivers?${params.toString()}`, { headers:{'Accept':'application/json'}, cache:'no-store' });
        if(!res.ok) throw new Error('HTTP '+res.status);
        const payload = await res.json();
        const list = Array.isArray(payload)? payload : (payload.drivers ?? []);
        const normalized = list.map(normalizeDriver).filter(d => Number.isFinite(d.lat) && Number.isFinite(d.lng));
        renderDrivers(normalized);
      }catch(e){ console.error('فشل تحميل بيانات السائقين:', e); }
    }

    function upsertMarker(d){
      const color = statusColors[d.status] || '#64748b';
      let marker = markersById.get(d.id);
      if(!marker){
        marker = L.circleMarker(d.lat, d.lng], { radius:9, color, weight:2, fillColor:color, fillOpacity:0.75 }).addTo(markersLayer);
        markersById.set(d.id, marker);
      }else{
        marker.setLatLng(d.lat, d.lng]);
        marker.setStyle({ color, fillColor: color });
      }
      marker.bindPopup(
        `<div dir="rtl" class="text-sm leading-6" style="min-width:200px">
          <div><strong>👤 الاسم:</strong> ${d.name ?? 'سائق'}</div>
          <div><strong>🚗 السيارة:</strong> ${d.car_number ?? '—'}</div>
          <div><strong>📍 الحالة:</strong> ${d.status ?? '—'}</div>
          <div><strong>⏱️ آخر تحديث:</strong> ${fmtTime(d.updated_at)}</div>
          <a target="_blank" href="https://www.google.com/maps?q=${d.lat},${d.lng}" class="text-blue-600 underline mt-2 inline-block">🔎 افتح في الخرائط</a>
        </div>`
      );
    }

    function renderDrivers(drivers){
      const seen = new Set();
      drivers.forEach(d => {
        if (!Number.isFinite(d.lat) || !Number.isFinite(d.lng)) return;
        if (withinBounds.checked) {
          const b = map.getBounds();
          if (!b.contains(d.lat, d.lng])) return;
        }
        upsertMarker(d);
        seen.add(d.id);
      });

      [...markersById.keys()].forEach(id => {
        if(!seen.has(id)){
          const m = markersById.get(id);
          if(m){ markersLayer.removeLayer(m); }
          markersById.delete(id);
        }
      });

      driversCount.textContent = markersById.size.toString();
      lastUpdated.textContent = new Date().toLocaleString();

      const groupBounds = markersLayer.getLayers().length ? markersLayer.getBounds() : null;
      if (groupBounds && (firstLoadFit || !lastBounds || !groupBounds.equals(lastBounds))) {
        map.fitBounds(groupBounds.pad(0.2));
        lastBounds = groupBounds;
        firstLoadFit = false;
        invalidateSafe();
      }
    }

    applyFilterBtn.addEventListener('click', fetchDrivers);
    clearFilterBtn.addEventListener('click', () => { statusFilter.value=''; fetchDrivers(); });
    refreshBtn.addEventListener('click', fetchDrivers);

    locateBtn.addEventListener('click', () => {
      if(!navigator.geolocation) return alert('المتصفح لا يدعم تحديد الموقع');
      navigator.geolocation.getCurrentPosition(pos => {
        const { latitude, longitude } = pos.coords;
        const you = L.circleMarker(latitude, longitude], {radius:10, color:'#3b82f6', fillColor:'#3b82f6', fillOpacity:0.5, weight:2})
                      .addTo(map).bindPopup('📍 موقعي الحالي');
        you.openPopup();
        map.setView(latitude, longitude], 14);
        invalidateSafe();
      }, () => alert('تعذر الحصول على الموقع'));
    });

    fitBtn.addEventListener('click', () => {
      const b = markersLayer.getLayers().length ? markersLayer.getBounds() : null;
      if (b) { map.fitBounds(b.pad(0.2)); invalidateSafe(); }
    });

    autoRefresh.addEventListener('change', () => {
      if (autoRefresh.checked) autoTimer = setInterval(fetchDrivers, 10000);
      else if (autoTimer){ clearInterval(autoTimer); autoTimer=null; }
    });

    if (window.Echo && typeof window.Echo.channel === 'function') {
      window.Echo.channel('drivers')
        .listen('.DriverStatusUpdated', (e) => {
          const d = {
            id: e.id ?? e.driver_id,
            name: e.name,
            car_number: e.car_number,
            status: e.status,
            lat: typeof e.lat === 'string' ? parseFloat(e.lat) : (e.lat ?? e.latitude),
            lng: typeof e.lng === 'string' ? parseFloat(e.lng) : (e.lng ?? e.longitude),
            updated_at: e.updated_at
          };
          if (!Number.isFinite(d.lat) || !Number.isFinite(d.lng)) return;
          if (withinBounds.checked) {
            const b = map.getBounds();
            if (!b.contains(d.lat, d.lng])) return;
          }
          upsertMarker(d);
          lastUpdated.textContent = new Date().toLocaleString();
          driversCount.textContent = markersById.size.toString();
          invalidateSafe();
        });
    } else {
      console.warn('Echo غير مُفعّل على الواجهة. تأكّد من إعدادات الباندلر وملف bootstrap.js');
    }

    fetchDrivers();
    autoRefresh.checked = true;
    autoTimer = setInterval(fetchDrivers, 10000);
    window.addEventListener('pageshow', () => {
      const b = markersLayer.getLayers().length ? markersLayer.getBounds() : null;
      if (b) { map.fitBounds(b.pad(0.2)); invalidateSafe(); }
    });
  });
  </script>
  @endverbatim
</x-app-layout>
