<?php if (isset($component)) { $__componentOriginal66d7cfd03cd343304d81fe1e21646540 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal66d7cfd03cd343304d81fe1e21646540 = $attributes; } ?>
<?php $component = App\View\Components\MainLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('main-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\MainLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => '🚖 حالة طلب Delni Taxi']); ?>
    <?php if(session('success')): ?>
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4 text-center max-w-xl mx-auto">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    
    <div class="bg-white p-6 rounded shadow max-w-xl mx-auto mt-8">
        <h2 class="text-xl font-bold text-gray-800 text-center mb-4">⭐ قيّم السائق</h2>
        <form method="POST" action="<?php echo e(route('submit.rating')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="driver_name" value="<?php echo e($driver->name); ?>">
            <div class="mb-4 text-right">
                <label for="rating" class="block text-gray-700 font-semibold mb-1">التقييم:</label>
                <select name="rating" id="rating" class="w-full border rounded px-3 py-2">
                    <option value="">اختر التقييم</option>
                    <option value="5">⭐⭐⭐⭐⭐ ممتاز</option>
                    <option value="4">⭐⭐⭐⭐ جيد جدًا</option>
                    <option value="3">⭐⭐⭐ جيد</option>
                    <option value="2">⭐⭐ مقبول</option>
                    <option value="1">⭐ ضعيف</option>
                </select>
            </div>
            <div class="mb-4 text-right">
                <label for="comment" class="block text-gray-700 font-semibold mb-1">ملاحظات:</label>
                <textarea name="comment" id="comment" rows="3" class="w-full border rounded px-3 py-2"></textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="bg-yellow-500 text-white px-5 py-2 rounded hover:bg-yellow-600 transition">
                    إرسال التقييم
                </button>
            </div>
        </form>
    </div>

    
    <div class="max-w-2xl mx-auto px-4 py-10 text-center">
        <h1 class="text-3xl font-bold text-yellow-600 mb-4">🚖 طلبك قيد التنفيذ</h1>
<p class="text-gray-700 mb-6">
    <?php if($order->status === 'قيد التنفيذ'): ?>
        تم إرسال طلبك! السائق الأقرب في طريقه إليك.
    <?php elseif($order->status === 'بدأت الرحلة'): ?>
        🚖 الرحلة بدأت! استمتع بمشوارك.
    <?php elseif($order->status === 'منتهي'): ?>
        ✅ الرحلة منتهية.
    <?php else: ?>
        🚧 حالة الطلب: <?php echo e($order->status); ?>

    <?php endif; ?>
</p>


<h3 class="text-xl font-bold text-gray-700 mt-10 mb-2">🗺️ موقع الراكب (نقطة الانطلاق)</h3>
<div id="pickup-map" class="w-full h-[300px] rounded shadow border mb-6"></div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const pickupLat = <?php echo e($order->pickup_latitude); ?>;
        const pickupLng = <?php echo e($order->pickup_longitude); ?>;

        const pickupMap = L.map('pickup-map').setView([pickupLat, pickupLng], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(pickupMap);

        L.marker([pickupLat, pickupLng]).addTo(pickupMap)
            .bindPopup("📍 موقع الراكب (نقطة الانطلاق)")
            .openPopup();
    });
</script>

<div class="bg-white shadow-md rounded-lg p-6 mb-6">
    <h3 class="text-xl font-semibold text-yellow-600 mb-4 flex items-center gap-2">
        👨‍✈️ تفاصيل السائق
    </h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-700 text-right">
        <div>
            <span class="font-bold">👨‍✈️ الاسم:</span> <?php echo e($driver->name); ?>

        </div>
        <div>
            <span class="font-bold">🚗 السيارة:</span> <?php echo e($driver->car_number); ?>

        </div>
        <div>
            <span class="font-bold">📱 رقم الهاتف:</span> <?php echo e($driver->phone ?? 'غير متوفر'); ?>

        </div>
        <div>
            <span class="font-bold">⏱️ الوصول المتوقع:</span>
            <span id="eta" class="text-blue-600 font-semibold">جارٍ الحساب...</span>
        </div>
    </div>
</div>

        <div class="mb-4">
            <button id="contactDriverBtn" class="bg-blue-500 text-white px-6 py-2 rounded-full hover:bg-blue-600 transition">
                📞 تواصل مع السائق
            </button>
        </div>

        
        <div id="map" class="w-full h-[500px] rounded-lg shadow mb-6"></div>

        
<div class="max-w-xl mx-auto bg-white shadow rounded-lg p-5 mt-10">
    <h2 class="text-xl font-bold text-yellow-600 mb-4 text-center">💬 المحادثة مع السائق</h2>

    <div id="chatBox" class="h-64 overflow-y-auto border border-gray-300 p-4 rounded-lg bg-gray-50 space-y-2 text-sm text-right">
        
    </div>

    <form id="chatForm" class="mt-4 flex gap-3">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">
        <input type="hidden" name="sender" value="user">
        <input 
            type="text" 
            name="message" 
            placeholder="✍️ اكتب رسالتك هنا..." 
            class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" 
            required
        >
        <button 
            type="submit" 
            class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-lg transition"
        >
            إرسال
        </button>
    </form>
</div>
        
        <div class="text-center mt-8 space-y-4">
<div class="flex flex-col sm:flex-row justify-center items-center gap-4 mt-6">
<?php if($order->status === 'قيد التنفيذ'): ?>
    <form action="<?php echo e(route('taxi.order.start', $order->id)); ?>" method="POST" onsubmit="return confirm('هل أنت متأكد أنك تريد بدء الرحلة؟')">
        <?php echo csrf_field(); ?>
        <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-3 rounded-lg shadow transition-all duration-200">
            🚦 بدأ الرحلة
        </button>
    </form>
<?php endif; ?>

    
    <button onclick="cancelOrder()" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg shadow transition-all duration-200">
        ❌ إلغاء الطلب
    </button>

    
<form action="<?php echo e(route('taxi.complete.with.rating')); ?>" method="POST" onsubmit="return confirm('هل أنت متأكد من إنهاء الرحلة وتقييم السائق؟')">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">
    <input type="hidden" name="driver_id" value="<?php echo e($driver->id); ?>">
    <input type="hidden" name="driver_name" value="<?php echo e($driver->name); ?>">
    <input type="hidden" name="rating" value="5">
    <input type="hidden" name="comment" value="رحلة ممتازة">

    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg shadow transition-all duration-200">
        ✅ إنهاء الرحلة
    </button>
</form>

    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const arrivalSound = new Audio('/sounds/arrival.mp3');
        const messageSound = new Audio('/sounds/message.mp3');
        let lastMessageCount = 0;

        const driver = {
            lat: <?php echo e($driver->latitude); ?>,
            lon: <?php echo e($driver->longitude); ?>,
            name: "<?php echo e($driver->name); ?>",
            car: "<?php echo e($driver->car_number); ?>"
        };

        const user = {
            lat: <?php echo e($order->pickup_latitude); ?>,
            lon: <?php echo e($order->pickup_longitude); ?>

        };

        document.getElementById("contactDriverBtn").addEventListener("click", () => {
            alert("📞 سيتم الاتصال بالسائق الآن...");
        });

        const map = L.map('map').setView([user.lat, user.lon], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        const taxiIcon = L.icon({
            iconUrl: '/images/taxi-icon.png',
            iconSize: [36, 36],
            iconAnchor: [18, 36]
        });

        const driverMarker = L.marker([driver.lat, driver.lon], { icon: taxiIcon }).addTo(map).bindPopup("🚕 السائق هنا").openPopup();
        const userMarker = L.circleMarker([user.lat, user.lon], {
            radius: 8,
            fillColor: "#007BFF",
            color: "#fff",
            weight: 2,
            fillOpacity: 0.9
        }).addTo(map).bindPopup("📍 موقعك").openPopup();

        const pathLine = L.polyline([[driver.lat, driver.lon], [user.lat, user.lon]], { color: 'blue' }).addTo(map);

        const speed = 0.0005;
        let arrived = false;

        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                    Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                    Math.sin(dLon/2) * Math.sin(dLon/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }

        function moveDriver() {
            const dLat = user.lat - driver.lat;
            const dLon = user.lon - driver.lon;
            const dist = Math.sqrt(dLat * dLat + dLon * dLon);

            if (dist < 0.0006 && !arrived) {
                arrived = true;
                document.getElementById("eta").textContent = "🚖 السائق وصل!";
                arrivalSound.play();
                clearInterval(moveInterval);
                return;
            }

            driver.lat += dLat * speed;
            driver.lon += dLon * speed;
            driverMarker.setLatLng([driver.lat, driver.lon]);
            pathLine.setLatLngs([[driver.lat, driver.lon], [user.lat, user.lon]]);

            const kmDistance = calculateDistance(driver.lat, driver.lon, user.lat, user.lon);
            const estimatedTime = kmDistance / 0.4;
            const minutes = Math.floor(estimatedTime);
            const seconds = Math.round((estimatedTime - minutes) * 60);
            document.getElementById("eta").textContent = `${minutes} دقيقة ${seconds} ثانية (${kmDistance.toFixed(2)} كم)`;
        }

// 🟢 تحديث موقع السائق من السيرفر كل 5 ثوانٍ
setInterval(async function () {
    const res = await fetch("<?php echo e(route('api.driver.location', $driver->id)); ?>");
    const data = await res.json();

    driver.lat = parseFloat(data.latitude);
    driver.lon = parseFloat(data.longitude);

    // تحديث موقع السائق على الخريطة
    driverMarker.setLatLng([driver.lat, driver.lon]);

    // تحديث الخط بين السائق والراكب
    pathLine.setLatLngs([[driver.lat, driver.lon], [user.lat, user.lon]]);

    // تحديث الوقت والمسافة المتبقية
    const kmDistance = calculateDistance(driver.lat, driver.lon, user.lat, user.lon);
    const estimatedTime = kmDistance / 0.4; // سرعة افتراضية: 40 كم/ساعة
    const minutes = Math.floor(estimatedTime);
    const seconds = Math.round((estimatedTime - minutes) * 60);
    document.getElementById("eta").textContent = `${minutes} دقيقة ${seconds} ثانية (${kmDistance.toFixed(2)} كم)`;

    if (kmDistance < 0.05) {
        document.getElementById("eta").textContent = "🚖 السائق وصل!";
        arrivalSound.play();
    }
}, 5000);

        function cancelOrder() {
            if (confirm("هل أنت متأكد من إلغاء الطلب؟")) {
                window.location.href = "<?php echo e(route('home')); ?>";
            }
        }

        // ✅ المحادثة
async function loadMessages() {
    const orderId = "<?php echo e($order->id); ?>";
    const res = await fetch("<?php echo e(route('driver.message.fetch')); ?>?order_id=" + orderId);
    const messages = await res.json();
    const chatBox = document.getElementById("chatBox");

    if (messages.length > lastMessageCount) {
        messageSound.play();
        lastMessageCount = messages.length;
    }

    chatBox.innerHTML = "";

    messages.forEach(msg => {
        const msgDiv = document.createElement("div");

        // تنسيق الوقت
        const date = new Date(msg.created_at);
        const formattedTime = date.toLocaleTimeString('ar-EG', {
            hour: '2-digit',
            minute: '2-digit'
        });

        if (msg.sender === 'user') {
            msgDiv.className = "bg-yellow-100 text-gray-800 p-2 rounded-lg text-right w-fit ml-auto max-w-[80%]";
            msgDiv.innerHTML = `
                <strong>👤 أنت:</strong> ${msg.message}
                <br><small class="text-gray-500">${formattedTime}</small>
            `;
        } else {
            msgDiv.className = "bg-gray-200 text-gray-800 p-2 rounded-lg text-right w-fit mr-auto max-w-[80%]";
            msgDiv.innerHTML = `
                <strong>🚕 السائق:</strong> ${msg.message}
                <br><small class="text-gray-500">${formattedTime}</small>
            `;
        }

        chatBox.appendChild(msgDiv);
    });

    chatBox.scrollTop = chatBox.scrollHeight;
}

        document.getElementById("chatForm").addEventListener("submit", async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            await fetch("<?php echo e(route('driver.message.store')); ?>", {
                method: "POST",
                body: formData
            });
            this.reset();
            loadMessages();
        });

        setInterval(loadMessages, 5000);
        loadMessages();
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal66d7cfd03cd343304d81fe1e21646540)): ?>
<?php $attributes = $__attributesOriginal66d7cfd03cd343304d81fe1e21646540; ?>
<?php unset($__attributesOriginal66d7cfd03cd343304d81fe1e21646540); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal66d7cfd03cd343304d81fe1e21646540)): ?>
<?php $component = $__componentOriginal66d7cfd03cd343304d81fe1e21646540; ?>
<?php unset($__componentOriginal66d7cfd03cd343304d81fe1e21646540); ?>
<?php endif; ?>
<?php /**PATH /home/delni_user/delni/resources/views/taxi/order-status.blade.php ENDPATH**/ ?>