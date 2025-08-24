<x-app-layout>
    <div class="max-w-xl mx-auto mt-10 p-6 bg-white rounded shadow">
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

            <div class="mb-4">
                <label class="block font-semibold mb-1">📛 الاسم</label>
                <input type="text" name="name" value="{{ $service->name }}" class="w-full border-gray-300 rounded px-4 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">🏙️ المدينة</label>
                <input type="text" name="city" value="{{ $service->city }}" class="w-full border-gray-300 rounded px-4 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">🛠️ نوع المركز</label>
                <select name="type" class="w-full border-gray-300 rounded px-4 py-2" required>
                    <option value="رافعة" {{ $service->type == 'رافعة' ? 'selected' : '' }}>رافعة</option>
                    <option value="مركز صيانة" {{ $service->type == 'مركز صيانة' ? 'selected' : '' }}>مركز صيانة</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">📞 رقم الموبايل</label>
                <input type="text" name="phone" value="{{ $service->phone }}" class="w-full border-gray-300 rounded px-4 py-2">
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">🌍 حدد موقع المركز على الخريطة</label>
                <div id="map" style="height: 300px;" class="rounded shadow mb-2"></div>
                <button type="button" onclick="getLocation()" class="bg-blue-500 text-white px-4 py-1 rounded text-sm">📍 حدد موقعي تلقائيًا</button>
                <input type="hidden" name="lat" id="lat" value="{{ $service->lat }}" required>
                <input type="hidden" name="lng" id="lng" value="{{ $service->lng }}" required>
            </div>

            <button type="submit" class="w-full bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600">
                💾 حفظ التعديلات
            </button>
        </form>
    </div>

    {{-- Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView({{ $service->lat }}, {{ $service->lng }}], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© Delni'
        }).addTo(map);

        var marker = L.marker({{ $service->lat }}, {{ $service->lng }}]).addTo(map);

        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            if (marker) {
                map.removeLayer(marker);
            }

            marker = L.marker(lat, lng]).addTo(map);

            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;
        });

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;

                    if (marker) {
                        map.removeLayer(marker);
                    }

                    marker = L.marker(lat, lng]).addTo(map);
                    map.setView(lat, lng], 15);

                    document.getElementById('lat').value = lat;
                    document.getElementById('lng').value = lng;
                });
            } else {
                alert("المتصفح لا يدعم تحديد الموقع الجغرافي.");
            }
        }
    </script>
</x-app-layout>
