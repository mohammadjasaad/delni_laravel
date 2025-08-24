<x-main-layout title="🗺️ خريطة السائقين">

    <div class="max-w-6xl mx-auto mt-8">
        <h1 class="text-2xl font-bold text-center text-yellow-600 mb-4">🗺️ خريطة السائقين المتاحين</h1>
        <div id="map" class="w-full h-[600px] rounded-lg shadow"></div>
    </div>

    {{-- Leaflet CDN --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const map = L.map('map').setView(34.8021, 38.9968], 7); // تمركز على سوريا

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        let markers = [];

        function loadDrivers() {
            fetch('{{ route('api.drivers') }}')
                .then(response => response.json())
                .then(drivers => {
                    // حذف العلامات القديمة
                    markers.forEach(marker => map.removeLayer(marker));
                    markers = [];

                    // إضافة علامات جديدة
                    drivers.forEach(driver => {
                        const marker = L.marker(driver.latitude, driver.longitude]).addTo(map);
                        marker.bindPopup(
                            `<strong>👤 ${driver.name}</strong><br>🚗 ${driver.car_number}<br>📍 الحالة: ${driver.status}`
                        );
                        markers.push(marker);
                    });
                })
                .catch(error => console.error('فشل في تحميل السائقين:', error));
        }

        // تحميل أولي
        loadDrivers();

        // إعادة التحميل كل 10 ثواني
        setInterval(loadDrivers, 10000);
    </script>

</x-main-layout>
