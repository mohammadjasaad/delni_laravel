<x-app-layout>
    <div class="max-w-3xl mx-auto mt-10 p-6 bg-white rounded shadow" dir="rtl">
        <h2 class="text-2xl font-bold text-yellow-600 text-center mb-6">➕ أضف مركز طوارئ جديد</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                <ul class="list-disc ps-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            // fallback ذكي لاسم مسار الحفظ (سواء emergency_services.store أو emergency.store)
            $storeAction = \Illuminate\Support\Facades\Route::has('emergency_services.store')
                ? route('emergency_services.store')
                : (\Illuminate\Support\Facades\Route::has('emergency.store')
                    ? route('emergency.store')
                    : url('/emergency-services'));
        @endphp

        <form id="createEmergencyForm" method="POST" action="{{ $storeAction }}" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block font-semibold mb-1">📛 الاسم</label>
                <input id="name" type="text" name="name" class="w-full border border-gray-300 rounded px-4 py-2"
                       value="{{ old('name') }}" required autofocus placeholder="مثال: ونش سريع دمشق">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="city" class="block font-semibold mb-1">🏙️ المدينة</label>
                    <input id="city" type="text" name="city" class="w-full border border-gray-300 rounded px-4 py-2"
                           value="{{ old('city') }}" required placeholder="دمشق، حلب...">
                </div>

                <div>
                    <label for="type" class="block font-semibold mb-1">🛠️ نوع المركز</label>
                    <select id="type" name="type" class="w-full border border-gray-300 rounded px-4 py-2" required>
                        <option value="" hidden>اختر النوع</option>
                        <option value="رافعة" {{ old('type') === 'رافعة' ? 'selected' : '' }}>رافعة</option>
                        <option value="مركز صيانة" {{ old('type') === 'مركز صيانة' ? 'selected' : '' }}>مركز صيانة</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="phone" class="block font-semibold mb-1">📞 رقم الموبايل (اختياري)</label>
                <input id="phone" type="text" name="phone" class="w-full border border-gray-300 rounded px-4 py-2"
                       value="{{ old('phone') }}" placeholder="مثال: 0966123456" pattern="[0-9+\-\s]{6,20}">
                <p class="text-xs text-gray-500 mt-1">يمكنك إدخال أرقام ومسافات ورمز + فقط.</p>
            </div>

            <div>
                <label class="block font-semibold mb-1">🌍 حدّد موقع المركز على الخريطة</label>
                <div id="map" class="rounded shadow mb-2" style="height: 320px;"></div>

                <div class="flex items-center gap-2 text-sm mb-2">
                    <button type="button" id="locateBtn"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                        📍 حدد موقعي تلقائيًا
                    </button>
                    <span class="text-gray-700">الإحداثيات المختارة:</span>
                    <code id="coordsPreview" class="bg-gray-100 px-2 py-1 rounded">—</code>
                </div>

                {{-- الحقول الفعلية --}}
                <input type="hidden" name="lat" id="lat" value="{{ old('lat') }}" required>
                <input type="hidden" name="lng" id="lng" value="{{ old('lng') }}" required>
            </div>

            <button type="submit"
                    class="w-full bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600 font-bold">
                ✅ إضافة المركز
            </button>
        </form>
    </div>

    {{-- Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        (function () {
            const $lat = document.getElementById('lat');
            const $lng = document.getElementById('lng');
            const $coordsPreview = document.getElementById('coordsPreview');
            const $form = document.getElementById('createEmergencyForm');
            const $locateBtn = document.getElementById('locateBtn');

            // نقطة بداية (دمشق) أو من old()
            const startLat = parseFloat($lat.value) || 33.5138;
            const startLng = parseFloat($lng.value) || 36.2765;
            const hasOld = Number.isFinite(parseFloat($lat.value)) && Number.isFinite(parseFloat($lng.value));

            const map = L.map('map', { scrollWheelZoom: true }).setView(startLat, startLng], hasOld ? 15 : 12);
            const tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            let marker = null;

            function setMarker(lat, lng, fit = false) {
                if (marker) map.removeLayer(marker);
                marker = L.marker(lat, lng]).addTo(map);
                $lat.value = lat;
                $lng.value = lng;
                $coordsPreview.textContent = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                if (fit) map.setView(lat, lng], 15);
            }

            // إن كانت هناك قيم قديمة (فشل تحقق سابق)
            if (hasOld) {
                setMarker(parseFloat($lat.value), parseFloat($lng.value), true);
            }

            map.on('click', function (e) {
                setMarker(e.latlng.lat, e.latlng.lng, false);
            });

            $locateBtn.addEventListener('click', function () {
                if (!navigator.geolocation) {
                    alert('المتصفح لا يدعم تحديد الموقع.');
                    return;
                }
                navigator.geolocation.getCurrentPosition(
                    (pos) => {
                        const lat = pos.coords.latitude;
                        const lng = pos.coords.longitude;
                        setMarker(lat, lng, true);
                    },
                    () => alert('تعذر الحصول على الموقع حالياً.')
                );
            });

            // تحقّق بسيط قبل الإرسال
            $form.addEventListener('submit', function (ev) {
                if (!Number.isFinite(parseFloat($lat.value)) || !Number.isFinite(parseFloat($lng.value))) {
                    ev.preventDefault();
                    alert('يرجى اختيار موقع المركز من الخريطة أولاً.');
                }
            });

            // إصلاح سريع لحجم الخريطة في حال تغيّر الحاوية
            const invalidate = () => { try { map.invalidateSize(true); } catch (_) {} };
            setTimeout(invalidate, 0);
            setTimeout(invalidate, 300);
            window.addEventListener('resize', invalidate);
            tiles.on('load', invalidate);
        })();
    </script>
</x-app-layout>
