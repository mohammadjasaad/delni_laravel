<x-main-layout title="🚖 Delni Taxi">

    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-xl shadow space-y-6 text-center">

        {{-- ✅ عنوان --}}
        <h1 class="text-3xl font-bold text-yellow-600 mb-4">🚖 اطلب تاكسي Delni الآن</h1>
        <p class="text-gray-700 text-lg">نحدد موقعك الحالي ونجد أقرب سائق إليك...</p>

        {{-- ✅ الخريطة --}}
        <div id="map" class="w-full h-96 rounded-lg border shadow"></div>

        {{-- ✅ زر الطلب --}}
<form action="{{ route('taxi.request') }}" method="POST">
    @csrf
    <input type="hidden" name="lat" value="33.5138">
    <input type="hidden" name="lng" value="36.2765">
    <button type="submit"
        class="mt-6 px-6 py-3 bg-yellow-500 text-white font-bold rounded-full hover:bg-yellow-600 transition">
        🛺 اطلب سيارة الآن
    </button>
</form>

    </div>

    {{-- ✅ سكربت خريطة OpenStreetMap --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // الموقع الافتراضي (دمشق)
            var map = L.map('map').setView([33.5138, 36.2765], 13);

            // الخلفية
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; Delni Taxi',
            }).addTo(map);

            // تحديد الموقع الجغرافي
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    map.setView([lat, lng], 15);

                    // 🔵 موقع المستخدم
                    L.marker([lat, lng])
                        .addTo(map)
                        .bindPopup('📍 موقعك الحالي').openPopup();

                    // 🟢 سائق وهمي قريب
                    const driverLat = lat + 0.002;
                    const driverLng = lng + 0.002;
                    const driverMarker = L.marker([driverLat, driverLng], {
                        icon: L.icon({
                            iconUrl: '/taxi-icon.png',
                            iconSize: [32, 32],
                            iconAnchor: [16, 32],
                            popupAnchor: [0, -30],
                        })
                    }).addTo(map);
                    driverMarker.bindPopup('🚖 سائق Delni قريب منك!');
                });
            }
        });
    </script>

</x-main-layout>
