{{-- resources/views/emergency_services/show.blade.php --}}
<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-yellow-600 mb-6 text-center">👁️ تفاصيل مركز الطوارئ</h1>

        {{-- ✅ بيانات المركز --}}
        <div class="bg-white rounded-lg shadow p-6 space-y-4 text-gray-800">
            <div><strong>📛 الاسم:</strong> {{ $service->name }}</div>
            <div><strong>🏙️ المدينة:</strong> {{ $service->city }}</div>
            <div><strong>🛠️ النوع:</strong> {{ $service->type }}</div>
            <div><strong>📌 الإحداثيات:</strong> {{ $service->lat }}, {{ $service->lng }}</div>

            @if($service->description)
                <div><strong>📝 تفاصيل:</strong> {{ $service->description }}</div>
            @endif
            @if($service->phone)
                <div><strong>📞 هاتف:</strong> <a href="tel:{{ $service->phone }}" class="text-blue-600">{{ $service->phone }}</a></div>
            @endif
            @if($service->whatsapp)
                <div><strong>💬 واتساب:</strong> <a href="https://wa.me/{{ $service->whatsapp }}" target="_blank" class="text-green-600">{{ $service->whatsapp }}</a></div>
            @endif
            @if($service->email)
                <div><strong>📧 بريد:</strong> <a href="mailto:{{ $service->email }}" class="text-purple-600">{{ $service->email }}</a></div>
            @endif
        </div>

        {{-- 🗺️ خريطة المركز والمراكز القريبة --}}
        <div class="mt-6">
            <h2 class="text-lg font-semibold mb-2">🌍 الموقع والمراكز القريبة</h2>
            <div id="map" class="w-full h-[400px] rounded shadow"></div>
        </div>

        {{-- 🔙 زر العودة --}}
        <div class="text-center mt-8">
            <a href="{{ route('emergency_services.index') }}" 
               class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded text-gray-700">
                ⬅️ عودة إلى القائمة
            </a>
        </div>
    </div>

    {{-- Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const map = L.map('map').setView([{{ $service->lat }}, {{ $service->lng }}], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; Delni.co'
            }).addTo(map);

            // ✅ marker للمركز الحالي
            L.marker([{{ $service->lat }}, {{ $service->lng }}], {
                icon: L.icon({
                    iconUrl: 'https://maps.gstatic.com/mapfiles/ms2/micons/red-dot.png',
                    iconSize: [32, 32]
                })
            }).addTo(map)
                .bindPopup("<strong>{{ $service->name }}</strong><br>{{ $service->city }} (المركز الحالي)")
                .openPopup();

            // ✅ markers للمراكز القريبة
            const nearby = @json($nearby);
            nearby.forEach(p => {
                if (p.lat && p.lng) {
                    L.marker([p.lat, p.lng]).addTo(map)
                        .bindPopup(`
                            <strong>${p.name}</strong><br>
                            ${p.city ?? ''} - ${p.type ?? ''}<br>
                            <a href='/emergency-services/${p.id}' class='text-blue-600 underline'>👁️ عرض</a>
                        `);
                }
            });
        });
    </script>
</x-app-layout>
