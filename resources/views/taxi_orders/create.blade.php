<x-main-layout title="🚖 إضافة طلب تاكسي">
    <div class="max-w-3xl mx-auto bg-white p-6 shadow rounded-lg mt-8">
        <h2 class="text-2xl font-bold text-center mb-6">🚖 إضافة طلب تاكسي جديد</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('taxi.orders.store.public') }}" class="space-y-6">
            @csrf

            {{-- اسم الراكب --}}
            <div>
                <label class="block font-semibold">👤 اسم الراكب</label>
                <input type="text" name="user_name" class="w-full border rounded p-2" required>
            </div>

            {{-- اختيار السائق --}}
            <div>
                <label class="block font-semibold">🚗 اختر السائق</label>
                <select name="driver_id" class="w-full border rounded p-2">
                    <option value="">(اختيار تلقائي لأقرب سائق)</option>
                    @foreach(($drivers ?? []) as $d)
                        <option value="{{ $d->id }}">{{ $d->name }} {{ $d->status ? "— $d->status" : '' }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">اتركه فارغًا لاختيار أقرب سائق تلقائيًا.</p>
            </div>

            {{-- الانطلاق --}}
            <div class="flex items-center justify-between">
                <label class="block font-semibold">📍 إحداثيات الانطلاق</label>
                <div class="flex gap-2">
                    <button type="button" id="btnLocatePickup" class="text-sm bg-gray-100 px-3 py-1 rounded border">📍 تحديد موقعي</button>
                    <button type="button" id="btnTogglePickupMap" class="text-sm bg-gray-100 px-3 py-1 rounded border">🗺️ من الخريطة</button>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                <input id="pickup_lat" type="text" name="pickup_latitude" placeholder="Latitude" class="w-full border rounded p-2" required>
                <input id="pickup_lng" type="text" name="pickup_longitude" placeholder="Longitude" class="w-full border rounded p-2" required>
            </div>
            <div id="pickupMapWrap" class="hidden">
                <div id="pickupMap" class="h-64 rounded border"></div>
                <p class="text-xs text-gray-500 mt-2">اسحب المؤشر لتغيير موقع الانطلاق.</p>
            </div>

            {{-- الوصول --}}
            <div class="flex items-center justify-between">
                <label class="block font-semibold">🎯 إحداثيات الوصول</label>
                <div class="flex gap-2">
                    <button type="button" id="btnCopyFromPickup" class="text-sm bg-gray-100 px-3 py-1 rounded border">↘️ نفس الانطلاق</button>
                    <button type="button" id="btnToggleDropMap" class="text-sm bg-gray-100 px-3 py-1 rounded border">🗺️ من الخريطة</button>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                <input id="drop_lat" type="text" name="dropoff_latitude" placeholder="Latitude" class="w-full border rounded p-2" required>
                <input id="drop_lng" type="text" name="dropoff_longitude" placeholder="Longitude" class="w-full border rounded p-2" required>
            </div>
            <div id="dropMapWrap" class="hidden">
                <div id="dropMap" class="h-64 rounded border"></div>
                <p class="text-xs text-gray-500 mt-2">اسحب المؤشر لتغيير موقع الوصول.</p>
            </div>

            {{-- عنوان الوجهة --}}
            <div>
                <label class="block font-semibold">🏠 اسم/عنوان الوجهة</label>
                <input type="text" name="destination_name" class="w-full border rounded p-2" placeholder="اختياري">
            </div>

            {{-- الحالة --}}
            <div>
                <label class="block font-semibold">📌 الحالة</label>
                <select name="status" class="w-full border rounded p-2">
                    <option value="قيد التنفيذ">قيد التنفيذ</option>
                    <option value="بدأت الرحلة">بدأت الرحلة</option>
                    <option value="منتهي">منتهي</option>
                    <option value="ملغي">ملغي</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-yellow-500 text-white py-2 rounded hover:bg-yellow-600">
                💾 حفظ الطلب
            </button>
        </form>
    </div>

    {{-- Leaflet CSS/JS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // نقطة افتراضية: دمشق
        const DEFAULT_CENTER = { lat: 33.5138, lng: 36.2765 };

        let pickupMap, dropMap, pickupMarker, dropMarker;
        let pickupInitialized = false, dropInitialized = false;

        const el = (id) => document.getElementById(id);

        // أزرار إظهار الخرائط
        el('btnTogglePickupMap').addEventListener('click', () => {
            el('pickupMapWrap').classList.toggle('hidden');
            if (!pickupInitialized) initPickupMap();
            setTimeout(() => pickupMap?.invalidateSize(), 200);
        });

        el('btnToggleDropMap').addEventListener('click', () => {
            el('dropMapWrap').classList.toggle('hidden');
            if (!dropInitialized) initDropMap();
            setTimeout(() => dropMap?.invalidateSize(), 200);
        });

        // زر نسخ الانطلاق للوصول
        el('btnCopyFromPickup').addEventListener('click', () => {
            el('drop_lat').value = el('pickup_lat').value;
            el('drop_lng').value = el('pickup_lng').value;
            if (dropInitialized && dropMarker) {
                const lat = parseFloat(el('drop_lat').value);
                const lng = parseFloat(el('drop_lng').value);
                if (!isNaN(lat) && !isNaN(lng)) {
                    dropMarker.setLatLng(lat, lng]);
                    dropMap.setView(lat, lng], 15);
                }
            }
        });

        // زر تحديد موقعي للانطلاق
        el('btnLocatePickup').addEventListener('click', () => {
            if (!navigator.geolocation) return alert('🚫 المتصفح لا يدعم تحديد الموقع.');
            navigator.geolocation.getCurrentPosition(pos => {
                const { latitude, longitude } = pos.coords;
                el('pickup_lat').value = latitude.toFixed(6);
                el('pickup_lng').value = longitude.toFixed(6);
                if (pickupInitialized && pickupMarker) {
                    pickupMarker.setLatLng(latitude, longitude]);
                    pickupMap.setView(latitude, longitude], 15);
                }
            }, err => {
                alert('تعذر الحصول على موقعك: ' + (err.message || 'خطأ غير معروف'));
            }, { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 });
        });

        function initPickupMap() {
            pickupInitialized = true;
            const start = getLatLngFromInputs('pickup_lat','pickup_lng') || DEFAULT_CENTER;

            pickupMap = L.map('pickupMap').setView(start.lat, start.lng], 14);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(pickupMap);

            pickupMarker = L.marker(start.lat, start.lng], { draggable: true }).addTo(pickupMap);

            pickupMarker.on('dragend', () => {
                const { lat, lng } = pickupMarker.getLatLng();
                el('pickup_lat').value = lat.toFixed(6);
                el('pickup_lng').value = lng.toFixed(6);
            });

            // لو كتب المستخدم إحداثيات يدويًا نحرك المؤشر
            ['pickup_lat','pickup_lng'].forEach(id => {
                el(id).addEventListener('change', () => moveMarkerFromInputs(pickupMarker, pickupMap, 'pickup_lat','pickup_lng'));
            });
        }

        function initDropMap() {
            dropInitialized = true;
            const start = getLatLngFromInputs('drop_lat','drop_lng') || DEFAULT_CENTER;

            dropMap = L.map('dropMap').setView(start.lat, start.lng], 14);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(dropMap);

            dropMarker = L.marker(start.lat, start.lng], { draggable: true }).addTo(dropMap);

            dropMarker.on('dragend', () => {
                const { lat, lng } = dropMarker.getLatLng();
                el('drop_lat').value = lat.toFixed(6);
                el('drop_lng').value = lng.toFixed(6);
            });

            ['drop_lat','drop_lng'].forEach(id => {
                el(id).addEventListener('change', () => moveMarkerFromInputs(dropMarker, dropMap, 'drop_lat','drop_lng'));
            });
        }

        function getLatLngFromInputs(latId, lngId) {
            const lat = parseFloat(el(latId).value);
            const lng = parseFloat(el(lngId).value);
            if (isFinite(lat) && isFinite(lng)) return { lat, lng };
            return null;
        }

        function moveMarkerFromInputs(marker, map, latId, lngId) {
            const v = getLatLngFromInputs(latId, lngId);
            if (!v) return;
            marker.setLatLng(v.lat, v.lng]);
            map.setView(v.lat, v.lng], 15);
        }

        // تحسين تجربة الجوال: منع التمرير داخل الخريطة من سحب الصفحة
        ['pickupMap','dropMap'].forEach(mid => {
            const wrap = document.getElementById(mid);
            wrap?.addEventListener('touchmove', (e) => e.stopPropagation(), { passive: true });
        });
    </script>
</x-main-layout>
