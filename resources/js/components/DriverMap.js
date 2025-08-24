// resources/js/components/DriverMap.js

import L from "leaflet";

const orderId = 5; // غيّر رقم الطلب حسب الحالة

// ✅ إنشاء الخريطة (دمشق كمثال مبدئي)
const map = L.map("driver-map").setView([33.5138, 36.2765], 13);

// ✅ تحميل خرائط OpenStreetMap
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 19,
}).addTo(map);

// ✅ إضافة ماركر افتراضي
let driverMarker = L.marker([33.5138, 36.2765]).addTo(map);

// ✅ الاستماع للتحديثات من Pusher
window.Echo.channel(`driver.location.${orderId}`)
    .listen(".DriverLocationUpdated", (data) => {
        console.log("📡 تحديث موقع السائق:", data);

        const { latitude, longitude } = data;

        // تحديث موقع الماركر
        driverMarker.setLatLng([latitude, longitude]);

        // تحريك الخريطة إلى الموقع الجديد
        map.setView([latitude, longitude], 15);
    });
