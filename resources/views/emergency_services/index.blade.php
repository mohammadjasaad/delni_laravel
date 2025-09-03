{{-- resources/views/emergency_services/index.blade.php --}}
<x-app-layout title="مراكز الطوارئ">
    <div class="max-w-7xl mx-auto px-4 py-8 space-y-6">

        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">مراكز الطوارئ</h1>

            @auth
                <a href="{{ route('emergency_services.create') }}"
                   class="inline-flex items-center px-4 py-2 rounded bg-yellow-500 text-white hover:bg-yellow-600">
                    + إضافة مركز
                </a>
            @endauth
        </div>

        {{-- زر تحديد الموقع --}}
        <div class="text-center my-4">
            <button onclick="getLocation()"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                📍 حدد موقعي لعرض المراكز القريبة
            </button>
        </div>

        {{-- الخريطة --}}
        <div class="bg-white rounded shadow p-3">
            <div id="map" style="height: 420px; border-radius: .5rem;"></div>
        </div>

        {{-- اللائحة --}}
        @if(isset($services) && $services->count())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($services as $service)
                    <div class="bg-white shadow rounded-lg p-4">
                        <h3 class="text-lg font-semibold">{{ $service->name ?? '—' }}</h3>
                        <p class="text-sm text-gray-600 mt-1">{{ $service->description ?? '—' }}</p>
                        @if(!empty($service->phone))
                            <p class="text-sm mt-1">☎ {{ $service->phone }}</p>
                        @endif
                        @if(!empty($service->city))
                            <p class="text-xs text-gray-500 mt-1">🏙 {{ $service->city }}</p>
                        @endif
                        @if(!empty($service->type))
                            <p class="text-xs text-gray-500 mt-1">🏷️ {{ $service->type }}</p>
                        @endif
                        @if(isset($service->distance))
                            <p class="text-xs text-blue-600 mt-1">
                                📏 المسافة: {{ number_format($service->distance, 2) }} كم
                            </p>
                        @endif

                        <div class="flex items-center gap-2 mt-3">
                            <a href="{{ route('emergency_services.show', $service->id) }}"
                               class="px-3 py-1.5 text-sm bg-gray-100 rounded hover:bg-gray-200">عرض</a>
                            @auth
                                <a href="{{ route('emergency_services.edit', $service->id) }}"
                                   class="px-3 py-1.5 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600">تعديل</a>
                                <form action="{{ route('emergency_services.destroy', $service->id) }}" method="POST"
                                      onsubmit="return confirm('تأكيد الحذف؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1.5 text-sm bg-red-500 text-white rounded hover:bg-red-600">
                                        حذف
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white shadow rounded-lg p-6 text-center text-gray-600">
                لا توجد مراكز مسجلة حاليًا.
            </div>
        @endif
    </div>

    {{-- Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const map = L.map('map').setView([33.5, 36.3], 8);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        // عرض المراكز
        fetch(@json(url('emergency-services/map-data')))
            .then(r => r.json())
            .then(points => {
                points.forEach(p => {
                    if (p.lat && p.lng) {
                        const marker = L.marker([p.lat, p.lng]).addTo(map);
                        const link = @json(route('emergency_services.show', ['id' => 'ID_PLACEHOLDER'])).replace('ID_PLACEHOLDER', p.id);
                        marker.bindPopup(`
                            <strong>${p.name}</strong><br>
                            ${p.city ?? ''} - ${p.type ?? ''}<br>
                            <a href="${link}" class="text-blue-600 underline">عرض التفاصيل</a>
                        `);
                    }
                });
            });

        // ✅ جلب موقع المستخدم
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(pos => {
                    const lat = pos.coords.latitude;
                    const lng = pos.coords.longitude;

                    L.marker([lat, lng], {icon: L.icon({
                        iconUrl: 'https://maps.gstatic.com/mapfiles/ms2/micons/blue-dot.png',
                        iconSize: [32, 32]
                    })}).addTo(map).bindPopup("📍 موقعي الحالي").openPopup();

                    // إعادة تحميل الصفحة مع الإحداثيات
                    window.location.href = `?lat=${lat}&lng=${lng}`;
                });
            } else {
                alert("المتصفح لا يدعم تحديد الموقع الجغرافي");
            }
        }
    </script>
</x-app-layout>
