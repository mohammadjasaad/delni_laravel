<x-main-layout title="🚖 طلبك قيد التنفيذ">
    <div class="max-w-3xl mx-auto px-4 py-8 space-y-6">

        <h2 class="text-2xl font-bold text-center text-yellow-600">🚖 تم تحديد أقرب سائق لك</h2>

        <!-- شاشة تحميل -->
        <div id="loadingScreen" class="text-center text-gray-600">
            ⏳ جاري تحميل بيانات السائق والخريطة...
        </div>

        <!-- بيانات السائق -->
        <div id="driverInfo" class="bg-white shadow rounded p-4 space-y-2 text-center hidden">
            <p><strong>👤 الاسم:</strong> <span id="driverName" class="font-bold text-lg text-gray-700"></span></p>
            <p><strong>🚗 رقم السيارة:</strong> <span id="driverCar" class="text-blue-600"></span></p>
            <p><strong>📞 رقم الهاتف:</strong> <span id="driverPhone" class="text-blue-600"></span></p>
        </div>

        <!-- الخريطة -->
        <div id="mapContainer" class="hidden">
            <div class="h-72 rounded overflow-hidden shadow" id="miniMap"></div>
        </div>

        <!-- أزرار التحكم -->
        <div id="controlButtons" class="flex justify-center gap-4 flex-wrap hidden">
            <button onclick="contactDriver()" class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full sm:w-auto">
                📞 تواصل مع السائق
            </button>
            <button onclick="showRatingForm()" class="flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded w-full sm:w-auto">
                ⭐ تقييم السائق
            </button>
            <button onclick="cancelOrder()" class="flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded w-full sm:w-auto">
                ❌ إلغاء الطلب
            </button>
        </div>

        <!-- نموذج التقييم -->
        <div id="ratingForm" class="hidden bg-gray-100 p-4 rounded space-y-3">
            <h3 class="text-lg font-semibold text-gray-700 text-center">⭐️ قيّم تجربتك مع السائق</h3>

            <div class="flex justify-center space-x-2 rtl:space-x-reverse" id="starContainer"></div>

            <textarea id="ratingText" class="w-full border border-gray-300 rounded p-2" placeholder="...أخبرنا عن تجربتك"></textarea>

            <div class="text-center">
                <button onclick="submitRating()" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                    إرسال التقييم
                </button>
            </div>
        </div>

    </div>

    {{-- Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    @php
        // نبني بايـلود من السيرفر إن كانت الصفحة افتُحت بـ /order-taxi/{driverId}
        $serverDriver = isset($driver) ? [
            'id'   => $driver->id,
            'name' => $driver->name ?? null,
            'car'  => $driver->car ?? ($driver->car_number ?? null),
            'phone'=> $driver->phone ?? ($driver->mobile ?? null),
            'lat'  => isset($driver->latitude)  ? (float)$driver->latitude  : null,
            'lon'  => isset($driver->longitude) ? (float)$driver->longitude : null,
        ] : null;
    @endphp

    <script>
        let selectedRating = 0;

        // نحاول أولاً من السيرفر، ثم من localStorage
        const serverDriver = @json($serverDriver);
        let driver = serverDriver ?? JSON.parse(localStorage.getItem("selectedDriver") || "null");

        if (!driver || driver.lat == null || driver.lon == null) {
            alert("🚫 لا يوجد طلب نشط.");
            setTimeout(() => { window.location.href = "{{ route('home') }}"; }, 1500);
        } else {
            initDriverData(driver);
        }

        function initDriverData(d) {
            document.getElementById("loadingScreen").classList.add("hidden");
            document.getElementById("driverInfo").classList.remove("hidden");
            document.getElementById("mapContainer").classList.remove("hidden");
            document.getElementById("controlButtons").classList.remove("hidden");

            document.getElementById("driverName").textContent  = d.name ?? '—';
            document.getElementById("driverCar").textContent   = d.car ?? '—';
            document.getElementById("driverPhone").textContent = d.phone ?? '—';

            // خريطة
            const map = L.map('miniMap').setView(d.lat, d.lon], 14);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap contributors' }).addTo(map);

            const taxiIcon = L.icon({ iconUrl: '/images/taxi-icon.png', iconSize: [38, 38], iconAnchor: [19, 38] });

            let driverMarker = L.marker(d.lat, d.lon], { icon: taxiIcon }).addTo(map).bindPopup("🚖 السائق هنا").openPopup();

            // تحديث لحظي — يقبل lat/lon أو latitude/longitude
            setInterval(() => {
                fetch(`/api/driver-location/${d.id}`)
                    .then(res => res.json())
                    .then(data => {
                        const newLat = (data.lat ?? data.latitude);
                        const newLon = (data.lon ?? data.longitude);
                        if (newLat != null && newLon != null) {
                            driverMarker.setLatLng(newLat, newLon]);
                            map.setView(newLat, newLon]);
                        }
                    })
                    .catch(err => console.error("خطأ في جلب الموقع:", err));
            }, 5000);
        }

        function cancelOrder() {
            if (confirm("❗ هل أنت متأكد من إلغاء الطلب؟")) {
                localStorage.removeItem("selectedDriver");
                window.location.href = "{{ route('home') }}";
            }
        }

        function contactDriver() {
            const phone = (driver?.phone || '').replace(/\s+/g, '');
            if (!phone) return alert("🚫 رقم الهاتف غير متوفر");
            if (phone.startsWith('+')) window.open(`https://wa.me/${phone}`, '_blank');
            else window.location.href = `tel:${phone}`;
        }

        function showRatingForm() {
            document.getElementById("ratingForm").classList.remove("hidden");
            renderStars();
        }

        function renderStars() {
            const container = document.getElementById("starContainer");
            container.innerHTML = '';
            for (let i = 1; i <= 5; i++) {
                const star = document.createElement("span");
                star.textContent = "★";
                star.className = "text-3xl cursor-pointer transition " + (i <= selectedRating ? "text-yellow-500" : "text-gray-300");
                star.onmouseover = () => { selectedRating = i; renderStars(); };
                star.onclick     = () => { selectedRating = i; renderStars(); };
                container.appendChild(star);
            }
        }

        function submitRating() {
            const text = document.getElementById("ratingText").value;
            if (selectedRating === 0) return alert("⚠️ يرجى اختيار عدد النجوم قبل الإرسال.");

            fetch("{{ route('submit.rating') }}", {
                method: "POST",
                headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    driver_id: driver.id,
                    rating: selectedRating,
                    comment: text
                })
            })
            .then(res => res.json())
            .then(() => {
                alert("✅ تم إرسال التقييم بنجاح");
                document.getElementById("ratingForm").classList.add("hidden");
                selectedRating = 0;
                document.getElementById("ratingText").value = '';
            })
            .catch(err => {
                console.error(err);
                alert("❌ حدث خطأ أثناء إرسال التقييم");
            });
        }
    </script>
</x-main-layout>
