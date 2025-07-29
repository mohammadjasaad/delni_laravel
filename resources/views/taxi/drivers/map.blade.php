<x-app-layout>
    <div class="max-w-6xl mx-auto p-6 mt-10 bg-white shadow-md rounded-lg">
        <h2 class="text-3xl font-bold text-center text-yellow-600 mb-6">
            🗺️ {{ __('messages.drivers_map') ?? 'خريطة السائقين التفاعلية' }}
        </h2>

        {{-- ✅ عنصر الخريطة --}}
        <div id="map" class="w-full h-[600px] rounded-lg shadow"></div>
    </div>

    {{-- ✅ مكتبة Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-sA+4B58zJzCix5nCoGQrg+YfVjtTao0Dft+KkS4t5b8=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-o9N1jRH1cG9CRrA1LV++yQ42ccF0Kq4vC94puhFQwYQ=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const map = L.map('map').setView([34.8021, 38.9968], 7);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const statusColors = {
            'متاح': 'green',
            'مشغول': 'red',
            'غير متصل': 'gray'
        };

        let markersLayer = L.layerGroup().addTo(map); // لتجميع وتحديث العلامات

        // ✅ دالة لتحميل السائقين وإعادة رسمهم
        async function loadDrivers() {
            try {
                const response = await fetch('/api/drivers');
                const drivers = await response.json();

                markersLayer.clearLayers(); // حذف العلامات القديمة

                drivers.forEach(driver => {
                    if (driver.lat && driver.lon) {
                        const marker = L.circleMarker([driver.lat, driver.lon], {
                            radius: 9,
                            color: statusColors[driver.status] || 'blue',
                            fillColor: statusColors[driver.status] || 'blue',
                            fillOpacity: 0.85
                        });

                        marker.bindPopup(`
                            <div dir="rtl" class="text-sm leading-6">
                                <div><strong>👤 الاسم:</strong> ${driver.name}</div>
                                <div><strong>🚗 السيارة:</strong> ${driver.car_number}</div>
                                <div><strong>📍 الحالة:</strong> ${driver.status}</div>
                                <a href="/drivers/${driver.id}" class="text-blue-600 underline mt-2 inline-block">🔎 عرض التفاصيل</a>
                            </div>
                        `);

                        marker.addTo(markersLayer);
                    }
                });

            } catch (error) {
                console.error('فشل تحميل بيانات السائقين:', error);
            }
        }

        // ⏱️ التحديث التلقائي كل 15 ثانية
        loadDrivers();
        setInterval(loadDrivers, 15000);
    });
</script>
</x-app-layout>
