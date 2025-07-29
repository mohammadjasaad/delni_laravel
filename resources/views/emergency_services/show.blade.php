<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-yellow-600 mb-6 text-center">👁️ تفاصيل مركز الطوارئ</h1>

        <div class="bg-white rounded-lg shadow p-6 space-y-4 text-gray-800">
            <div><strong>📛 الاسم:</strong> {{ $service->name }}</div>
            <div><strong>🏙️ المدينة:</strong> {{ $service->city }}</div>
            <div><strong>🛠️ النوع:</strong> {{ $service->type }}</div>
            <div><strong>📌 الإحداثيات:</strong> {{ $service->lat }}, {{ $service->lng }}</div>
        </div>

        {{-- 🗺️ خريطة الموقع --}}
        <div class="mt-6">
            <div id="map" class="w-full h-[400px] rounded shadow"></div>
        </div>

        {{-- 🔙 زر العودة --}}
        <div class="text-center mt-8">
            <a href="{{ route('emergency.index') }}" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded text-gray-700">
                ⬅️ عودة إلى القائمة
            </a>
        </div>
    </div>

    {{-- Leaflet Map --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const map = L.map('map').setView([{{ $service->lat }}, {{ $service->lng }}], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; Delni.co'
            }).addTo(map);

            const marker = L.marker([{{ $service->lat }}, {{ $service->lng }}]).addTo(map)
                .bindPopup("<strong>{{ $service->name }}</strong><br>{{ $service->city }}")
                .openPopup();
        });
    </script>
</x-app-layout>
