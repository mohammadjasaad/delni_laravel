<x-app-layout>
    <div class="max-w-7xl mx-auto mt-10 px-4">
        <h1 class="text-2xl font-bold mb-4 text-center text-yellow-600">🗺️ خريطة السائقين المتاحين</h1>

        <div id="map" class="w-full h-[600px] rounded shadow"></div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-o9N1j7kC1hHEz3zT0QzN7xy6kGkEq7u5ZkT4yF0C8v0="
        crossorigin=""></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-o9N1j7kC1hHEz3zT0QzN7xy6kGkEq7u5ZkT4yF0C8v0="
        crossorigin="" />

    <script>
        var map = L.map('map').setView(33.5138, 36.2765], 12); // دمشق كموقع افتراضي

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const drivers = @json($drivers);

drivers.forEach(driver => {
    if (driver.latitude && driver.longitude) {
        const iconColor = driver.status === 'مشغول' ? 'red' : 'green';

        const customIcon = L.icon({
            iconUrl: `https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=S|${iconColor}|000000`,
            iconSize: [21, 34],
            iconAnchor: [10, 34],
            popupAnchor: [0, -30]
        });

        const marker = L.marker(driver.latitude, driver.longitude], { icon: customIcon }).addTo(map)
            .bindPopup(`<strong>${driver.name}</strong><br>🚗 ${driver.car_number}<br>📍 ${driver.status}`);
    }
});
    </script>
</x-app-layout>
