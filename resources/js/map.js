export function initMap(mapId, latInputId, lngInputId, defaultLat = 34.8021, defaultLng = 38.9968, defaultZoom = 6) {
    const mapElement = document.getElementById(mapId);
    if (!mapElement) return;

    // ✅ إنشاء الخريطة
    var map = L.map(mapId).setView([defaultLat, defaultLng], defaultZoom);

    // ✅ الطبقة الأساسية (OSM)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var marker;
    map.on('click', function(e) {
        if (marker) {
            map.removeLayer(marker);
        }
        marker = L.marker(e.latlng).addTo(map);

        // تخزين القيم في الحقول المخفية
        document.getElementById(latInputId).value = e.latlng.lat;
        document.getElementById(lngInputId).value = e.latlng.lng;
    });
import { initMap } from './map';

// 🏠 العقارات
document.addEventListener("DOMContentLoaded", () => {
    initMap('realestate_map', 'realestate_latitude', 'realestate_longitude');
    initMap('car_map', 'car_latitude', 'car_longitude');
    initMap('service_map', 'service_latitude', 'service_longitude');
});

}
