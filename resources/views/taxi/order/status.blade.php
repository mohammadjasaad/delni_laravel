{{-- resources/views/taxi/order/status.blade.php --}}
<x-main-layout title="🚖 Delni Taxi - حالة الطلب">

    {{-- ✅ رأس الصفحة --}}
    <section class="bg-yellow-400 text-center py-8 shadow">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900">
            🚖 حالة طلبك الحالية
        </h1>
        <p class="text-gray-700 mt-2">تابع موقع السائق في الوقت الحقيقي وراقب تقدم الرحلة</p>
    </section>

    {{-- ✅ محتوى الصفحة --}}
    <div class="max-w-5xl mx-auto mt-8 p-6 bg-white rounded-2xl shadow-lg space-y-8">

        {{-- 🗺️ الخريطة --}}
        <div id="map" class="w-full h-[450px] rounded-xl border border-gray-200 shadow"></div>

        {{-- 🧭 حالة الطلب --}}
        <div class="flex flex-col md:flex-row items-center justify-between bg-gray-50 rounded-xl p-5 shadow-inner">
            <div class="flex items-center gap-3">
                <span class="text-3xl">📦</span>
                <div class="text-left">
                    <p class="text-gray-700 text-sm font-semibold">حالة الرحلة</p>
                    <p class="text-yellow-600 font-bold text-lg">
                        {{ $order->status ?? 'قيد التنفيذ' }}
                    </p>
                </div>
            </div>
            <div class="text-center md:text-right mt-4 md:mt-0">
                <button id="refreshMap"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-full shadow transition">
                    🔄 تحديث الموقع
                </button>
            </div>
        </div>

        {{-- 👨‍✈️ معلومات السائق --}}
        <div class="bg-gray-50 rounded-xl p-6 shadow-inner">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">👨‍✈️ السائق</h2>

            @if ($driver)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-gray-700">
                    <div>
                        <p class="font-semibold">الاسم:</p>
                        <p>{{ $driver->name }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">رقم الهاتف:</p>
                        <p>{{ $driver->phone ?? 'غير متوفر' }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">رقم السيارة:</p>
                        <p>{{ $driver->car_number ?? 'غير محدد' }}</p>
                    </div>
                </div>
            @else
                <p class="text-gray-500">⏳ جارٍ البحث عن أقرب سائق...</p>
            @endif
        </div>

        {{-- ⭐ تقييم السائق --}}
        @if ($order->status === 'completed')
            <div class="bg-gray-50 rounded-xl p-6 shadow-inner text-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">⭐ تقييم السائق</h2>
                <form action="{{ route('taxi.rating') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <div class="flex justify-center gap-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <label>
                                <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" required>
                                <span class="text-3xl cursor-pointer peer-checked:text-yellow-500 transition">⭐</span>
                            </label>
                        @endfor
                    </div>
                    <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-full shadow transition">
                        إرسال التقييم
                    </button>
                </form>
            </div>
        @endif

        {{-- 🔁 أزرار التحكم --}}
        <div class="flex flex-col md:flex-row justify-center items-center gap-4 mt-8">
            <a href="{{ route('delni.taxi') }}"
                class="bg-gray-700 hover:bg-gray-800 text-white font-semibold px-6 py-3 rounded-full shadow">
                ⬅️ العودة إلى البداية
            </a>

            <a href="{{ route('taxi.request') }}"
                class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-3 rounded-full shadow">
                🚕 طلب جديد
            </a>
        </div>
    </div>

    {{-- ✅ سكربت الخريطة --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

    <script>
        let map, userMarker, driverMarker;

        function initMap() {
            const userLat = {{ $order->pickup_lat ?? 33.5138 }};
            const userLng = {{ $order->pickup_lng ?? 36.2765 }};

            map = L.map('map').setView([userLat, userLng], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; Delni Taxi'
            }).addTo(map);

            // 📍 موقع الراكب
            userMarker = L.marker([userLat, userLng])
                .addTo(map)
                .bindPopup('📍 موقعك الحالي')
                .openPopup();

            // 👨‍✈️ موقع السائق (افتراضي)
            @if ($driver)
                const driverLat = {{ $driver->latitude ?? $order->pickup_lat + 0.01 }};
                const driverLng = {{ $driver->longitude ?? $order->pickup_lng + 0.01 }};
                driverMarker = L.marker([driverLat, driverLng])
                    .addTo(map)
                    .bindPopup('🚖 السائق {{ $driver->name }}');
            @endif
        }

        document.addEventListener('DOMContentLoaded', function() {
            initMap();

            document.getElementById('refreshMap').addEventListener('click', function() {
                location.reload();
            });
        });
    </script>
</x-main-layout>
