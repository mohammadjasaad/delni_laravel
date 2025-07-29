<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-8">

        {{-- 🟡 العنوان الرئيسي --}}
        <h1 class="text-3xl font-bold text-center text-yellow-600 mb-8">
            🚖 {{ __('messages.delni_taxi') }}
        </h1>

        {{-- 🗺️ الخريطة التفاعلية --}}
        <div id="map" class="w-full h-[400px] rounded shadow mb-8"></div>

        {{-- 👨‍✈️ معلومات أقرب سائق --}}
        @if(isset($nearestDriver))
            <div class="bg-white p-4 rounded shadow mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">🚗 أقرب سائق: {{ $nearestDriver->name }}</h2>
                <p class="text-gray-600">رقم السيارة: {{ $nearestDriver->car_number }}</p>
                <p class="text-gray-600">المسافة: {{ $nearestDriver->distance }} كم</p>
            </div>
        @endif

        {{-- 🔘 أزرار الخدمات --}}
        <div class="flex flex-wrap justify-center gap-4 mb-8">
            <a href="{{ route('order.taxi') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded shadow">
                🚕 اطلب سيارة الآن
            </a>
            <a href="{{ route('drivers.map') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow">
                🗺️ خريطة السائقين
            </a>
            <a href="{{ route('driver.login') }}" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded shadow">
                👨‍✈️ دخول السائق
            </a>
            <a href="{{ route('driver.dashboard') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow">
                🛠️ لوحة تحكم السائق
            </a>
        </div>

        {{-- ⏱️ حالة الطلب إن وجدت --}}
        @auth
            @if($activeOrder)
                <div class="bg-white p-4 rounded shadow mb-10">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">🕒 حالة الطلب الحالية</h3>
                    <p class="text-gray-700">السائق: <strong>{{ $activeOrder->driver_name }}</strong></p>
                    <p class="text-gray-700">الحالة: <strong>{{ $activeOrder->status }}</strong></p>
                    <a href="{{ route('order.status', ['id' => $activeOrder->id]) }}"
                       class="mt-4 inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow">
                        🔍 تفاصيل الطلب
                    </a>
                </div>
            @endif
        @endauth

    </div>

    {{-- 🌍 خريطة Leaflet --}}
    <script>
        var map = L.map('map').setView([{{ $userLat ?? 33.5 }}, {{ $userLng ?? 36.3 }}], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // ✅ موقع المستخدم
        L.marker([{{ $userLat ?? 33.5 }}, {{ $userLng ?? 36.3 }}])
            .addTo(map)
            .bindPopup("📍 موقعك الحالي")
            .openPopup();

        // ✅ السائقين على الخريطة
        @foreach($drivers as $driver)
            L.marker([{{ $driver->lat }}, {{ $driver->lng }}], {
                icon: L.icon({
                    iconUrl: 'https://cdn-icons-png.flaticon.com/512/2593/2593331.png',
                    iconSize: [30, 30],
                })
            })
            .addTo(map)
            .bindPopup("<strong>{{ $driver->name }}</strong><br>🚗 {{ $driver->car_number }}");
        @endforeach
    </script>
</x-app-layout>
