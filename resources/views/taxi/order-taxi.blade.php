<x-app-layout>
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-lg mt-6">
        <h1 class="text-2xl font-bold text-center text-yellow-600 mb-4">🚖 {{ __('messages.order_taxi') }}</h1>

        <!-- الخريطة -->
        <div id="map" class="w-full h-96 rounded-lg mb-6"></div>

        <!-- تفاصيل الطلب -->
        <form method="POST" action="{{ route('taxi.orders.store') }}">
            @csrf
            <input type="hidden" name="pickup_lat" id="pickup_lat">
            <input type="hidden" name="pickup_lng" id="pickup_lng">
            <input type="hidden" name="dest_lat" id="dest_lat">
            <input type="hidden" name="dest_lng" id="dest_lng">
            <input type="hidden" name="dest_address" id="dest_address">
            <input type="hidden" name="estimated_distance_m" id="estimated_distance_m">
            <input type="hidden" name="estimated_duration_s" id="estimated_duration_s">

            <!-- اختيار الوجهة -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">{{ __('messages.destination_address') }}</label>
                <input type="text" id="destination_input" class="border border-gray-300 rounded px-3 py-2 w-full" placeholder="📍 {{ __('messages.enter_destination') }}">
            </div>

            <!-- السعر المتوقع -->
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <strong>{{ __('messages.estimated_fare') }}:</strong>
                <span id="fare_display" class="text-yellow-600 font-bold">--</span> {{ __('messages.currency_syp') }}
            </div>

            <!-- زر التأكيد -->
            <button type="submit" id="confirm_btn" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 rounded-lg" disabled>
                ✅ {{ __('messages.confirm_order') }}
            </button>
        </form>
    </div>

    <!-- Leaflet & Routing -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css"/>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

    <script>
        let map = L.map('map').setView(33.5138, 36.2765], 13); // دمشق كنقطة بداية

        // إضافة الخريطة
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        let pickupMarker, destMarker, routeControl;

        // تحديد موقع المستخدم
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(pos => {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                map.setView(lat, lng], 15);
                pickupMarker = L.marker(lat, lng]).addTo(map).bindPopup("📍 نقطة الانطلاق").openPopup();
                document.getElementById('pickup_lat').value = lat;
                document.getElementById('pickup_lng').value = lng;
            });
        }

        // اختيار الوجهة بالنقر على الخريطة
        map.on('click', function(e) {
            if (destMarker) map.removeLayer(destMarker);
            destMarker = L.marker(e.latlng).addTo(map).bindPopup("🎯 الوجهة").openPopup();
            document.getElementById('dest_lat').value = e.latlng.lat;
            document.getElementById('dest_lng').value = e.latlng.lng;
            getRouteAndFare();
        });

        // حساب المسافة والزمن والسعر
        function getRouteAndFare() {
            if (!pickupMarker || !destMarker) return;

            if (routeControl) map.removeControl(routeControl);

            routeControl = L.Routing.control({
                waypoints: [
                    pickupMarker.getLatLng(),
                    destMarker.getLatLng()
                ],
                routeWhileDragging: false,
                show: false,
                addWaypoints: false
            }).on('routesfound', function(e) {
                let route = e.routes[0];
                let distance_m = route.summary.totalDistance;
                let duration_s = route.summary.totalTime;

                document.getElementById('estimated_distance_m').value = distance_m;
                document.getElementById('estimated_duration_s').value = duration_s;

                // جلب السعر من API
                fetch('{{ route("taxi.calculateFare") }}', {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        estimated_distance_m: distance_m,
                        estimated_duration_s: duration_s
                    })
                }).then(res => res.json())
                .then(data => {
                    document.getElementById('fare_display').innerText = data.fare;
                    document.getElementById('confirm_btn').disabled = false;
                });

            }).addTo(map);
        }
    </script>
</x-app-layout>
