<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 py-8">

        <h1 class="text-3xl font-bold text-center text-yellow-600 mb-6">
            🚖 {{ __('messages.delni_taxi') }}
        </h1>

        {{-- 🗺️ الخريطة --}}
        <div id="map" class="w-full h-[450px] rounded-lg shadow-md mb-6"></div>

        {{-- 🔘 أزرار التحكم --}}
        <div class="flex flex-wrap justify-center gap-4 mb-8">
            <button onclick="locateUser()" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                📍 حدد موقعي
            </button>

            <button onclick="findNearestDriver()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                🚗 العثور على أقرب سائق
            </button>

            <a href="#" id="requestRideBtn" onclick="submitTaxiOrder()"
               class="hidden bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded">
                🚕 اطلب سيارة الآن
            </a>
        </div>

        {{-- ⏱️ الطلب النشط --}}
        @auth
            @if($activeOrder)
                <div class="bg-white p-4 rounded shadow mb-10 border-l-4 border-yellow-500">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">🕒 لديك طلب نشط</h3>
                    <p class="text-gray-700">السائق: <strong>{{ $activeOrder->driver_name }}</strong></p>
                    <p class="text-gray-700">الحالة: <strong>{{ $activeOrder->status }}</strong></p>

                    <a href="{{ route('taxi.order.status', ['id' => $activeOrder->id]) }}"
                       class="mt-3 inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow">
                        🔍 متابعة الطلب
                    </a>
                </div>
            @endif
        @endauth

    </div>

    {{-- 🌍 خريطة Leaflet --}}
    <script>
        let userMarker, nearestDriverMarker, routeLine;

        var map = L.map('map').setView([{{ $userLat ?? 33.5 }}, {{ $userLng ?? 36.3 }}], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
        }).addTo(map);

        let drivers = [
            @foreach($drivers as $driver)
                { id: {{ $driver->id }}, name: "{{ $driver->name }}", lat: {{ $driver->latitude }}, lng: {{ $driver->longitude }}, car: "{{ $driver->car_number }}" },
            @endforeach
        ];

        drivers.forEach(d => {
            L.marker([d.lat, d.lng], {
                icon: L.icon({ iconUrl: 'https://cdn-icons-png.flaticon.com/512/2593/2593331.png', iconSize: [34, 34] })
            }).addTo(map).bindPopup(`<b>${d.name}</b><br>🚗 ${d.car}`);
        });

        function locateUser() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(pos => {
                    let lat = pos.coords.latitude;
                    let lng = pos.coords.longitude;

                    if (userMarker) map.removeLayer(userMarker);

                    userMarker = L.marker([lat, lng]).addTo(map).bindPopup("📍 موقعك").openPopup();
                    map.setView([lat, lng], 14);
                });
            }
        }

        function submitTaxiOrder() {
            if (!userMarker) {
                alert("📍 الرجاء تحديد موقعك أولاً");
                return;
            }

            let pos = userMarker.getLatLng();

            fetch("{{ route('taxi.order.store') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    user_id: {{ auth()->check() ? auth()->id() : 'null' }},
                    pickup_latitude: pos.lat,
                    pickup_longitude: pos.lng
                })
            })
            .then(res => res.redirected ? window.location.href = res.url : res.json())
            .then(data => {
                if (data.message) {
                    alert(data.message);
                }
            });
        }

        function findNearestDriver() {
            if (!userMarker) {
                alert("📍 الرجاء تحديد موقعك أولاً");
                return;
            }

            let userPos = userMarker.getLatLng();
            let nearest = null;
            let minDist = Infinity;

            drivers.forEach(driver => {
                let dist = map.distance([driver.lat, driver.lng], [userPos.lat, userPos.lng]);
                if (dist < minDist) {
                    minDist = dist;
                    nearest = driver;
                }
            });

            if (nearest) {
                if (nearestDriverMarker) map.removeLayer(nearestDriverMarker);
                if (routeLine) map.removeLayer(routeLine);

                nearestDriverMarker = L.marker([nearest.lat, nearest.lng]).addTo(map)
                    .bindPopup(`🚗 ${nearest.name}<br>${nearest.car}`)
                    .openPopup();

                routeLine = L.polyline([[nearest.lat, nearest.lng], [userPos.lat, userPos.lng]], { color: 'yellow' }).addTo(map);

                document.getElementById("requestRideBtn").classList.remove("hidden");
            }
        }
    </script>

</x-app-layout>
