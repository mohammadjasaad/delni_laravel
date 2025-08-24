<x-main-layout title="Delni Taxi 🚖">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-2 text-center text-yellow-600">🚖 Delni Taxi</h1>
        <p class="text-center text-gray-600 mb-4">استمتع بتجربة نقل مريحة، وسريعة وآمنة</p>

        <div class="bg-white rounded shadow p-4">
            <div id="map" class="w-full h-96 rounded"></div>

                <form method="POST" action="{{ route('taxi.request') }}">
    @csrf
    <button type="submit" class="bg-yellow-500 text-white px-6 py-3 rounded-full hover:bg-yellow-600 transition">
        🚕 اطلب سيارة الآن
    </button>
</form>

                <button id="contactDriverBtn" onclick="contactDriver()" class="hidden bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    تواصل مع السائق
                </button>
            </div>
        </div>
    </div>

    {{-- Leaflet.js --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        let nearestDriver = null;

        document.addEventListener("DOMContentLoaded", function () {
            const map = L.map('map').setView(33.5138, 36.2765], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            const taxiIcon = L.icon({
                iconUrl: '/images/taxi-icon.png',
                iconSize: [38, 38],
                iconAnchor: [19, 38],
                popupAnchor: [0, -38]
            });

            const drivers = [
                { lat: 33.52, lon: 36.28, name: "أبو أحمد", car: "دمشق 123456", phone: "0999123456" },
                { lat: 33.51, lon: 36.27, name: "أبو كريم", car: "دمشق 654321", phone: "0999765432" },
                { lat: 33.514, lon: 36.275, name: "أبو علي", car: "دمشق 987654", phone: "0999988776" }
            ];

            // عرض السائقين
            drivers.forEach(driver => {
                L.marker(driver.lat, driver.lon], { icon: taxiIcon })
                    .addTo(map)
                    .bindPopup(`🚖 ${driver.name}<br>🚗 ${driver.car}`);
            });

            // الموقع الجغرافي
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    const userLat = position.coords.latitude;
                    const userLon = position.coords.longitude;

                    L.circleMarker(userLat, userLon], {
                        radius: 8,
                        fillColor: "#007BFF",
                        color: "#fff",
                        weight: 2,
                        opacity: 1,
                        fillOpacity: 0.9
                    }).addTo(map).bindPopup("📍 أنت هنا").openPopup();

                    map.setView(userLat, userLon], 14);

                    // تحديد أقرب سائق
                    let minDistance = Infinity;

                    drivers.forEach(driver => {
                        const distance = haversine(userLat, userLon, driver.lat, driver.lon);
                        if (distance < minDistance) {
                            minDistance = distance;
                            nearestDriver = driver;
                        }
                    });

                    if (nearestDriver) {
                        // خط إلى السائق
                        L.polyline(
                            [userLat, userLon],
                            [nearestDriver.lat, nearestDriver.lon]
                        ], { color: 'red', dashArray: '5, 5' }).addTo(map);

                        L.popup()
                            .setLatLng((userLat + nearestDriver.lat) / 2, (userLon + nearestDriver.lon) / 2])
                            .setContent(`🚕 أقرب سائق: ${nearestDriver.name} يبعد ${minDistance.toFixed(2)} كم`)
                            .openOn(map);

                        document.getElementById("contactDriverBtn").classList.remove("hidden");
                    }

                }, function (error) {
                    console.error("❌ لم نتمكن من تحديد موقعك:", error);
                });
            }

            function haversine(lat1, lon1, lat2, lon2) {
                const R = 6371;
                const dLat = (lat2 - lat1) * Math.PI / 180;
                const dLon = (lon2 - lon1) * Math.PI / 180;
                const a = Math.sin(dLat / 2) ** 2 +
                    Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                    Math.sin(dLon / 2) ** 2;
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                return R * c;
            }
        });

        // زر طلب سيارة
        function orderTaxi() {
            if (nearestDriver) {
                localStorage.setItem('selectedDriver', JSON.stringify(nearestDriver));
                window.location.href = "{{ route('taxi.order.status') }}";
            } else {
                alert("❌ لم يتم تحديد أقرب سائق بعد.");
            }
        }

        // زر التواصل مع السائق
        function contactDriver() {
            if (nearestDriver) {
                alert(`📞 الاتصال بـ ${nearestDriver.name} على الرقم: ${nearestDriver.phone}`);
            } else {
                alert("❌ لم يتم العثور على سائق للتواصل معه.");
            }
        }
    </script>
</x-main-layout>
