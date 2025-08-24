<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-yellow-600 mb-6 text-center">👁️ تفاصيل مركز الطوارئ</h1>

        <div class="bg-white rounded-lg shadow p-6 space-y-4 text-gray-800">
            <div><strong>📛 الاسم:</strong> {{ $service->name }}</div>
            <div><strong>🏙️ المدينة:</strong> {{ $service->city }}</div>
            <div><strong>🛠️ النوع:</strong> {{ $service->type }}</div>
<div>
    <strong>📞 رقم الموبايل:</strong>
    @if (!empty($service->phone))
        {{ $service->phone }}

        {{-- زر واتساب --}}
        <div class="mt-2">
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $service->phone) }}"
               target="_blank"
               class="inline-flex items-center gap-2 bg-green-500 text-white px-3 py-1 rounded-full text-sm hover:bg-green-600 transition"
               title="تواصل عبر واتساب">
               {{-- أيقونة واتساب --}}
               <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 448 512">
                   <path d="M380.9 97.1C339-12.1 203.5-28.6 111 46.2c-62.2 50.3-79.7 136-43.1 204.8l-30.6 96.8 99.1-28.3c63.6 34.9 142.9 21.4 190.1-33.5 42.3-50.4 55.2-124.8 28.4-188.9zM212.1 341.4c-49.2 0-94.6-19.2-129-53.6-32.2-32.2-50-75-50-120.5s17.8-88.3 50-120.5C131.5 19.2 176.9 0 226.1 0c45.5 0 89.3 17.8 121.5 50s50 75 50 120.5c0 45.5-17.8 88.3-50 120.5-34.4 34.3-79.8 53.6-129 53.6zm61.4-93.1l-21.7-7.3c-5.8-1.9-12.1-.3-16.4 4.3l-10.1 10.5c-24.3-12.8-45.5-33.3-58.2-57.1l11.5-9.9c4.7-4 6.5-10.2 4.7-16l-7.2-22.3c-2.5-7.9-10.6-12.4-18.5-10.3-26.5 7.2-46 29.3-46 56.3 0 64.2 74.6 130.8 138.6 130.8 27.1 0 49.2-19.3 56.5-45.9 2.1-7.9-2.3-16-10.2-18.5z"/>
               </svg>
               <span class="hidden sm:inline">تواصل واتساب</span>
            </a>
        </div>
    @else
        لا يوجد
    @endif
</div>
            <div><strong>📌 الإحداثيات:</strong> يتم التحديد تلقائيًا على الخريطة</div>
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
            const map = L.map('map').setView({{ $service->lat }}, {{ $service->lng }}], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; Delni.co'
            }).addTo(map);

            const marker = L.marker({{ $service->lat }}, {{ $service->lng }}]).addTo(map)
                .bindPopup("<strong>{{ $service->name }}</strong><br>{{ $service->city }}")
                .openPopup();
        });
    </script>
</x-app-layout>
