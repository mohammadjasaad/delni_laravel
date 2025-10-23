<x-main-layout title="🚖 Delni Taxi - اطلب رحلتك الآن">

    {{-- ✅ رأس الصفحة --}}
    <section class="bg-yellow-400 text-center py-8 rounded-b-3xl shadow">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900">
            🚖 اطلب رحلتك الآن مع <span class="text-black">Delni Taxi</span>
        </h1>
        <p class="text-gray-700 mt-2">حدد موقعك وسنجد لك أقرب سائق فوراً ⏱️</p>
    </section>

    {{-- ✅ منطقة المحتوى --}}
    <div class="max-w-3xl mx-auto mt-8 p-6 bg-white rounded-2xl shadow-lg space-y-6 text-center">

        {{-- ✅ الخريطة --}}
        <div id="map" class="w-full h-[400px] rounded-xl border border-gray-200 shadow"></div>

        {{-- ✅ عرض الإحداثيات --}}
        <div class="mt-4 bg-gray-50 p-3 rounded-lg shadow-inner text-gray-700">
            📍 موقعك الحالي: 
            <span id="coords" class="text-yellow-600 font-semibold">جارِ التحديد...</span>
        </div>

        {{-- ✅ الأزرار --}}
        <div class="flex flex-col md:flex-row justify-center items-center gap-4 pt-4">
            <button id="getLocation"
                class="bg-white border-2 border-yellow-500 text-yellow-700 font-bold px-5 py-2 rounded-full hover:bg-yellow-100 transition">
                📍 استخدم موقعي الحالي
            </button>

            <form id="requestForm" action="{{ route('taxi.request') }}" method="POST">
                @csrf
                <input type="hidden" id="lat" name="lat">
                <input type="hidden" id="lng" name="lng">

                <button type="submit"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold px-6 py-3 rounded-full shadow-lg transition">
                    🚕 تأكيد الطلب الآن
                </button>
            </form>
        </div>

    </div>

    {{-- ✅ سكربت الخريطة --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

    <script>
        let map, marker;

        function initMap(lat = 33.5138, lng = 36.2765) {
            map = L.map('map').setView([lat, lng], 14);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; Delni Taxi',
            }).addTo(map);

            marker = L.marker([lat, lng]).addTo(map).bindPopup("📍 أنت هنا").openPopup();
            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;
            document.getElementById('coords').textContent = `${lat.toFixed(5)}, ${lng.toFixed(5)}`;
        }

        function updateLocation(lat, lng) {
            if (marker) map.removeLayer(marker);
            marker = L.marker([lat, lng]).addTo(map).bindPopup("📍 موقعك الحالي").openPopup();
            map.setView([lat, lng], 15);
            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;
            document.getElementById('coords').textContent = `${lat.toFixed(5)}, ${lng.toFixed(5)}`;
        }

        document.addEventListener("DOMContentLoaded", function () {
            initMap();

            document.getElementById('getLocation').addEventListener('click', () => {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        pos => updateLocation(pos.coords.latitude, pos.coords.longitude),
                        err => alert("⚠️ لم نتمكن من تحديد موقعك تلقائياً")
                    );
                } else {
                    alert("⚠️ متصفحك لا يدعم تحديد الموقع.");
                }
            });
        });
    </script>
</x-main-layout>
