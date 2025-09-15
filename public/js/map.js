document.addEventListener("DOMContentLoaded", function () {
    // ✅ معاينة الصور (يشتغل مع أي input عنده preview)
    function setupImagePreview(inputId, previewId) {
        const input = document.getElementById(inputId);
        if (input) {
            input.addEventListener('change', function (e) {
                let preview = document.getElementById(previewId);
                if (!preview) return;
                preview.innerHTML = "";
                Array.from(e.target.files).forEach(file => {
                    let reader = new FileReader();
                    reader.onload = e => {
                        let img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList = "h-24 w-32 object-cover rounded-lg shadow";
                        preview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            });
        }
    }

    // 🖼️ تطبيق على كل النماذج
    setupImagePreview('service_images', 'service_preview');
    setupImagePreview('realestate_images', 'realestate_preview');
    setupImagePreview('car_images', 'car_preview');

    // ✅ تهيئة الخرائط (يدعم services/ad/realestate)
    function setupMap(mapId, latId, lngId, locateBtnId, locatingMsgId) {
        const mapDiv = document.getElementById(mapId);
        if (!mapDiv) return;

        var defaultLat = 34.8021, defaultLng = 38.9968; // افتراضي سوريا
        var map = L.map(mapId).setView([defaultLat, defaultLng], 6);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);
        document.getElementById(latId).value = defaultLat;
        document.getElementById(lngId).value = defaultLng;

        // تحديث عند سحب الماركر
        marker.on('dragend', function () {
            var pos = marker.getLatLng();
            document.getElementById(latId).value = pos.lat;
            document.getElementById(lngId).value = pos.lng;
        });

        // تحديث عند الضغط على الخريطة
        map.on('click', function (e) {
            marker.setLatLng(e.latlng);
            document.getElementById(latId).value = e.latlng.lat;
            document.getElementById(lngId).value = e.latlng.lng;
        });

        // GPS عند فتح الصفحة
        if (navigator.geolocation) {
            if (locatingMsgId) document.getElementById(locatingMsgId)?.classList.remove('hidden');
            navigator.geolocation.getCurrentPosition(function (position) {
                var userLat = position.coords.latitude;
                var userLng = position.coords.longitude;
                map.setView([userLat, userLng], 14);
                marker.setLatLng([userLat, userLng]);
                document.getElementById(latId).value = userLat;
                document.getElementById(lngId).value = userLng;
                if (locatingMsgId) document.getElementById(locatingMsgId)?.classList.add('hidden');
            }, function () {
                if (locatingMsgId) document.getElementById(locatingMsgId)?.classList.add('hidden');
                console.warn("⚠️ لم يتم السماح بالوصول إلى الموقع.");
            });
        }

        // زر تحديد الموقع
        if (locateBtnId) {
            const locateBtn = document.getElementById(locateBtnId);
            if (locateBtn) {
                locateBtn.addEventListener('click', function () {
                    if (navigator.geolocation) {
                        if (locatingMsgId) document.getElementById(locatingMsgId)?.classList.remove('hidden');
                        navigator.geolocation.getCurrentPosition(function (position) {
                            var userLat = position.coords.latitude;
                            var userLng = position.coords.longitude;
                            map.setView([userLat, userLng], 14);
                            marker.setLatLng([userLat, userLng]);
                            document.getElementById(latId).value = userLat;
                            document.getElementById(lngId).value = userLng;
                            if (locatingMsgId) document.getElementById(locatingMsgId)?.classList.add('hidden');
                        }, function () {
                            if (locatingMsgId) document.getElementById(locatingMsgId)?.classList.add('hidden');
                            alert("⚠️ لم يتم السماح بالوصول إلى الموقع.");
                        });
                    } else {
                        alert("⚠️ المتصفح لا يدعم تحديد الموقع.");
                    }
                });
            }
        }
    }

    // 🗺️ تطبيق الخرائط على النماذج
    setupMap('service_map', 'service_latitude', 'service_longitude', 'locateMeBtn', 'locatingMessage');
    setupMap('ad_map', 'ad_latitude', 'ad_longitude', 'locateMeBtn', 'locatingMessage');
});
