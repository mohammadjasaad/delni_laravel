{{-- resources/views/taxi/request.blade.php --}}
<x-app-layout>
  @section('head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css"/>
    <style>
      #map{height:68vh;border-radius:16px}
      .search-wrap{gap:.5rem}
      .suggest{position:absolute;z-index:9999;left:0;right:0;background:#fff;border:1px solid #e5e7eb;border-top:0;max-height:220px;overflow:auto}
      .suggest button{display:block;width:100%;text-align:left;padding:.5rem .75rem}
      .tag{padding:.25rem .5rem;border-radius:999px;border:1px solid #e5e7eb;background:#fff}
      .tag:hover{background:#fef9c3}
    </style>
  @endsection

  <div class="max-w-6xl mx-auto py-6 px-4 space-y-4">
    <h1 class="text-2xl font-bold">🚖 اطلب تاكسي</h1>

    {{-- 🔎 بحث بالعنوان + زر موقعي --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-3">
      <div class="lg:col-span-8">
        <div class="flex flex-col md:flex-row search-wrap">
          <div class="relative w-full">
            <label class="text-sm text-gray-500">نقطة الانطلاق</label>
            <input id="pickupText" type="text" placeholder="اكتب عنوان الانطلاق..."
                   class="w-full border rounded-lg px-3 py-2">
            <div id="pickupSuggest" class="suggest hidden"></div>
          </div>
          <div class="relative w-full">
            <label class="text-sm text-gray-500">الوجهة</label>
            <input id="dropText" type="text" placeholder="اكتب عنوان الوجهة..."
                   class="w-full border rounded-lg px-3 py-2">
            <div id="dropSuggest" class="suggest hidden"></div>
          </div>
          <div class="flex items-end">
            <button id="useMyLocation" class="ml-0 md:ml-2 h-10 px-4 rounded-lg border bg-white">📍 موقعي</button>
          </div>
        </div>

        {{-- مدن رئيسية --}}
        <div class="flex flex-wrap gap-2 mt-2">
          <button class="tag city" data-lat="33.5138073" data-lng="36.2765279">دمشق</button>
          <button class="tag city" data-lat="36.2062933" data-lng="37.1579641">حلب</button>
          <button class="tag city" data-lat="34.730318"   data-lng="36.70964">حمص</button>
          <button class="tag city" data-lat="35.51749"    data-lng="35.78152">اللاذقية</button>
          <button class="tag city" data-lat="35.13178"    data-lng="36.75783">حماة</button>
          <button class="tag city" data-lat="34.88902"    data-lng="35.88659">طرطوس</button>
        </div>
      </div>

      {{-- صندوق السعر/المسافة + إرسال --}}
      <div class="lg:col-span-4">
        <div class="border rounded-xl p-4 bg-white shadow">
          <div class="text-sm text-gray-500">المسافة</div>
          <div class="text-2xl font-bold"><span id="distanceKm">—</span> كم</div>

          <div class="mt-3 text-sm text-gray-500">السعر المتوقع</div>
          <div class="text-3xl font-extrabold"><span id="fareSyp">—</span> ل.س</div>

          <form id="orderForm" method="POST" action="{{ route('taxi.order.store') }}" class="mt-4 space-y-2">
            @csrf
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            <input type="hidden" name="pickup_latitude"  id="pickup_latitude">
            <input type="hidden" name="pickup_longitude" id="pickup_longitude">
            <input type="hidden" name="dropoff_latitude"  id="dropoff_latitude">
            <input type="hidden" name="dropoff_longitude" id="dropoff_longitude">
            <input type="hidden" name="distance_km" id="distance_km">
            <input type="hidden" name="route_polyline" id="route_polyline">

            <button id="confirmBtn" type="submit"
                    class="w-full bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-4 py-2 rounded-lg disabled:opacity-50"
                    disabled>تأكيد الطلب</button>
          </form>

          <p class="text-xs text-gray-500 mt-2">يمكنك وضع النقاط بالنقر على الخريطة أو عبر البحث بالأعلى.</p>
        </div>
      </div>
    </div>

    {{-- الخريطة --}}
    <div id="map" class="relative"></div>
    <p class="text-sm text-gray-500">انقر أولاً لتحديد <b>نقطة الانطلاق</b> ثم انقر مرة أخرى لتحديد <b>الوجهة</b>. يمكنك سحب العلامات لتعديلهما.</p>
  </div>

  @section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
    <script>
      // خريطة ستايل داكن مثل Uber
      const map = L.map('map', { zoomControl:false }).setView([33.5138073,36.2765279], 13);
      L.control.zoom({ position: 'bottomright' }).addTo(map);
      L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution:'&copy; OpenStreetMap & CARTO'
      }).addTo(map);

      const $ = sel => document.querySelector(sel);
      const pickupLatEl  = $('#pickup_latitude');
      const pickupLngEl  = $('#pickup_longitude');
      const dropLatEl    = $('#dropoff_latitude');
      const dropLngEl    = $('#dropoff_longitude');
      const distEl       = $('#distance_km');
      const polyEl       = $('#route_polyline');
      const priceEl      = $('#fareSyp');
      const distanceLbl  = $('#distanceKm');
      const confirmBtn   = $('#confirmBtn');

      let pickupMarker=null, dropMarker=null, routeCtrl=null, lastRoute=null;

      // مدن سريعة
      document.querySelectorAll('.city').forEach(b=>{
        b.addEventListener('click', ()=> map.setView([+b.dataset.lat, +b.dataset.lng], 13));
      });

      // موقعي
      $('#useMyLocation').addEventListener('click', ()=>{
        if(navigator.geolocation){
          navigator.geolocation.getCurrentPosition(pos=>{
            const {latitude, longitude}=pos.coords;
            setPickup(L.latLng(latitude, longitude), true);
            map.setView([latitude, longitude], 14);
          });
        }
      });

      // نقر على الخريطة: أولاً انطلاق، ثانيًا وجهة، ثم إعادة
      map.on('click', (e)=>{
        if(!pickupMarker){ setPickup(e.latlng); }
        else if(!dropMarker){ setDrop(e.latlng); drawRoute(); }
        else { resetAll(); setPickup(e.latlng); }
      });

      function setPickup(latlng, skipDraw=false){
        if(pickupMarker) map.removeLayer(pickupMarker);
        pickupMarker = L.marker(latlng,{draggable:true}).addTo(map).bindPopup('نقطة الانطلاق').openPopup();
        pickupMarker.on('dragend', ()=>{ writePickup(pickupMarker.getLatLng()); if(dropMarker) drawRoute(); });
        writePickup(latlng);
        if(!skipDraw && dropMarker) drawRoute();
      }
      function setDrop(latlng){
        if(dropMarker) map.removeLayer(dropMarker);
        dropMarker = L.marker(latlng,{draggable:true}).addTo(map).bindPopup('الوجهة').openPopup();
        dropMarker.on('dragend', ()=>{ writeDrop(dropMarker.getLatLng()); if(pickupMarker) drawRoute(); });
        writeDrop(latlng);
      }
      function writePickup(ll){ pickupLatEl.value=ll.lat; pickupLngEl.value=ll.lng; }
      function writeDrop(ll){ dropLatEl.value=ll.lat; dropLngEl.value=ll.lng; }

      function resetAll(){
        if(pickupMarker){ map.removeLayer(pickupMarker); pickupMarker=null; }
        if(dropMarker){ map.removeLayer(dropMarker); dropMarker=null; }
        if(routeCtrl){ map.removeControl(routeCtrl); routeCtrl=null; }
        distEl.value=''; polyEl.value='';
        distanceLbl.textContent='—';
        priceEl.textContent='—';
        confirmBtn.disabled=true;
      }

      async function drawRoute(){
        if(!pickupMarker || !dropMarker) return;
        if(routeCtrl){ map.removeControl(routeCtrl); routeCtrl=null; }

        routeCtrl = L.Routing.control({
          waypoints:[ pickupMarker.getLatLng(), dropMarker.getLatLng() ],
          show:false, addWaypoints:false,
          router: L.Routing.osrmv1({ serviceUrl:'https://router.project-osrm.org/route/v1' }),
          lineOptions:{ addWaypoints:false }
        })
        .on('routesfound', async e=>{
          const r=e.routes[0];
          lastRoute=r;
          const km=(r.summary.totalDistance/1000).toFixed(2);
          distEl.value = km;
          distanceLbl.textContent = km;

          // خزّن polyline كبسيط [[lat,lng],...]
          const poly = r.coordinates.map(c=>[c.lat,c.lng]);
          polyEl.value = JSON.stringify(poly);

          // حساب السعر على السيرفر (يعتمد TaxiPricingService)
          try{
            const resp = await fetch("{{ url('/api/taxi/orders/quote') }}", {
              method:'POST',
              headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
              body: JSON.stringify({ distance_km: km })
            });
            if(resp.ok){
              const data = await resp.json();
              priceEl.textContent = (data.fare_syp ?? 0).toLocaleString('ar-SY');
            } else {
              // لو ما عندك مسار quote API جاهز، احسب محليًا (3000 + 1200*كم) مع حد أدنى 8000
              const local = Math.max(3000 + Math.round(km*1200), 8000);
              priceEl.textContent = local.toLocaleString('ar-SY');
            }
          }catch(_){
            const local = Math.max(3000 + Math.round(km*1200), 8000);
            priceEl.textContent = local.toLocaleString('ar-SY');
          }

          confirmBtn.disabled = false;
        })
        .addTo(map);
      }

      // ====== بحث بالعناوين (Nominatim) ======
      const pickupBox = $('#pickupText'), pickupSug = $('#pickupSuggest');
      const dropBox   = $('#dropText'),   dropSug   = $('#dropSuggest');

      function debounce(fn,ms){ let t; return (...a)=>{clearTimeout(t); t=setTimeout(()=>fn(...a),ms)} }
      const q = (term)=> `https://nominatim.openstreetmap.org/search?format=json&addressdetails=1&accept-language=ar&q=${encodeURIComponent(term)}`;

      async function doSearch(term, box, sug, cb){
        if(!term || term.length<3){ sug.classList.add('hidden'); sug.innerHTML=''; return; }
        const res = await fetch(q(term), { headers:{'Accept':'application/json'} });
        const arr = await res.json();
        sug.innerHTML = arr.slice(0,8).map(it=>`<button type="button" data-lat="${it.lat}" data-lng="${it.lon}">${it.display_name}</button>`).join('');
        sug.classList.remove('hidden');
        sug.querySelectorAll('button').forEach(b=>{
          b.addEventListener('click', ()=>{
            box.value = b.textContent.trim();
            sug.classList.add('hidden');
            const lat = parseFloat(b.dataset.lat), lng=parseFloat(b.dataset.lng);
            cb(L.latLng(lat,lng));
          });
        });
      }

      pickupBox.addEventListener('input', debounce(()=>doSearch(pickupBox.value, pickupBox, pickupSug, (ll)=>{ setPickup(ll); if(dropMarker) drawRoute(); }), 400));
      dropBox.addEventListener('input',   debounce(()=>doSearch(dropBox.value,   dropBox,   dropSug,   (ll)=>{ setDrop(ll);   if(pickupMarker) drawRoute(); }), 400));
      document.addEventListener('click', (e)=>{ if(!pickupSug.contains(e.target) && e.target!==pickupBox) pickupSug.classList.add('hidden'); if(!dropSug.contains(e.target) && e.target!==dropBox) dropSug.classList.add('hidden'); });

      // تلميح: لو أردت عرض المسار فور إدخال النصين بدون نقر خريطة — يتم تلقائياً بعد اختيار الاقتراح.

      // ====== تأكيد النموذج: تأكد أن القيم موجودة ======
      $('#orderForm').addEventListener('submit', (e)=>{
        if(!pickupLatEl.value || !pickupLngEl.value){ e.preventDefault(); alert('يرجى تحديد نقطة الانطلاق'); return; }
        // الوجهة ليست إلزامية في تحقّقك الحالي، لكن للتسعير نفضّلها:
        if(!dropLatEl.value || !dropLngEl.value){ e.preventDefault(); alert('يرجى تحديد الوجهة'); return; }
        if(!distEl.value){ e.preventDefault(); alert('لم يتم حساب المسافة'); return; }
      });
    </script>

    {{-- مسار quote اختياري: لو غير موجود سيعمل الحساب المحلي أعلاه --}}
    <script>
      // يمكنك إنشاء مسار API بسيط:
      // Route::post('/api/taxi/orders/quote', fn() => response()->json(['fare_syp' => max(3000 + (int)round(request('distance_km',0)*1200), 8000)]));
    </script>
  @endsection
</x-app-layout>

