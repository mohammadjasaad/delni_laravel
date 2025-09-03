<x-app-layout>
    <div class="max-w-3xl mx-auto mt-10 p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold text-yellow-600 text-center mb-6">✏️ تعديل مركز الطوارئ</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                <ul class="list-disc ps-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('emergency_services.update', $service->id) }}">
            @csrf
            @method('PUT')

            {{-- 📛 الاسم --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">📛 الاسم</label>
                <input type="text" name="name" value="{{ $service->name }}" class="w-full border-gray-300 rounded px-4 py-2" required>
            </div>

            {{-- 🏙️ المدينة --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">🏙️ المدينة</label>
                <input type="text" name="city" value="{{ $service->city }}" class="w-full border-gray-300 rounded px-4 py-2" required>
            </div>

            {{-- 🛠️ النوع --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">🛠️ نوع المركز</label>
                <select name="type" class="w-full border-gray-300 rounded px-4 py-2" required>
                    <option value="رافعة" {{ $service->type == 'رافعة' ? 'selected' : '' }}>رافعة</option>
                    <option value="مركز صيانة" {{ $service->type == 'مركز صيانة' ? 'selected' : '' }}>مركز صيانة</option>
                </select>
            </div>

            {{-- 📝 تفاصيل الخدمة --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">📝 تفاصيل الخدمة</label>
                <textarea name="description" rows="3" class="w-full border-gray-300 rounded px-4 py-2">{{ $service->description }}</textarea>
            </div>

            {{-- ☎️ الهاتف --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">📞 رقم الهاتف</label>
                <input type="text" name="phone" value="{{ $service->phone }}" class="w-full border-gray-300 rounded px-4 py-2">
            </div>

            {{-- 💬 واتساب --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">💬 رقم الواتساب</label>
                <input type="text" name="whatsapp" value="{{ $service->whatsapp }}" class="w-full border-gray-300 rounded px-4 py-2">
            </div>

            {{-- 📧 البريد --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">📧 البريد الإلكتروني</label>
                <input type="email" name="email" value="{{ $service->email }}" class="w-full border-gray-300 rounded px-4 py-2">
            </div>

            {{-- 🌍 البحث عن الموقع --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">🔍 ابحث عن الموقع</label>
                <input type="text" id="searchBox" placeholder="أدخل اسم مدينة أو عنوان..." class="w-full border-gray-300 rounded px-4 py-2">
                <button type="button" id="searchBtn"
                        class="mt-2 bg-green-500 hover:bg-green-600 text-white font-bold px-4 py-2 rounded shadow">
                    🔍 بحث
                </button>
            </div>

            {{-- 🌍 الخريطة لاختيار الموقع --}}
            <div class="mb-4">
                <label class="block font-semibold mb-2">🌍 حدد الموقع على الخريطة</label>
                <div id="map" class="w-full h-80 rounded-lg shadow border mb-3"></div>

                <button type="button" id="locateBtn"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-bold px-4 py-2 rounded shadow">
                    📍 استخدم موقعي الحالي
                </button>
            </div>

            {{-- 📍 الإحداثيات --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">📍 خط العرض (Latitude)</label>
                <input type="text" id="lat" name="lat" value="{{ $service->lat }}" class="w-full border-gray-300 rounded px-4 py-2" readonly required>
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1">📍 خط الطول (Longitude)</label>
                <input type="text" id="lng" name="lng" value="{{ $service->lng }}" class="w-full border-gray-300 rounded px-4 py-2" readonly required>
            </div>

            <button type="submit" class="w-full bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600">
                💾 حفظ التعديلات
            </button>
        </form>
    </div>

    {{-- ✅ مكتبة الخرائط --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    {{-- ✅ سكربت الخريطة --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const map = L.map('map').setView([{{ $service->lat ?? 34.8021 }}, {{ $service->lng ?? 38.9968 }}], 10);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; Delni.co'
            }).addTo(map);

            let marker = L.marker([{{ $service->lat ?? 34.8021 }}, {{ $service->lng ?? 38.9968 }}]).addTo(map);

            function setMarker(lat, lng) {
                if (marker) map.removeLayer(marker);
                marker = L.marker([lat, lng]).addTo(map);
                document.getElementById('lat').value = lat;
                document.getElementById('lng').value = lng;
            }

            map.on('click', function (e) {
                setMarker(e.latlng.lat.toFixed(6), e.latlng.lng.toFixed(6));
            });

            document.getElementById('locateBtn').addEventListener('click', function () {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (pos) {
                        const lat = pos.coords.latitude.toFixed(6);
                        const lng = pos.coords.longitude.toFixed(6);
                        setMarker(lat, lng);
                        map.setView([lat, lng], 15);
                    }, () => alert("⚠️ تعذر الحصول على الموقع."));
                } else {
                    alert("⚠️ المتصفح لا يدعم تحديد الموقع.");
                }
            });

            document.getElementById('searchBtn').addEventListener('click', function () {
                const query = document.getElementById('searchBox').value;
                if (!query) return alert("⚠️ أدخل اسم مدينة أو عنوان أولاً.");

                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            const lat = parseFloat(data[0].lat).toFixed(6);
                            const lng = parseFloat(data[0].lon).toFixed(6);
                            setMarker(lat, lng);
                            map.setView([lat, lng], 14);
                        } else {
                            alert("❌ لم يتم العثور على موقع.");
                        }
                    })
                    .catch(() => alert("⚠️ خطأ في البحث عن الموقع."));
            });
        });
    </script>
</x-app-layout>
