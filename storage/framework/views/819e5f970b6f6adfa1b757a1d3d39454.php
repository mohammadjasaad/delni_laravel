<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="max-w-3xl mx-auto mt-10 p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold text-yellow-600 text-center mb-6">➕ أضف مركز طوارئ جديد</h2>

        
        <?php if($errors->any()): ?>
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                <ul class="list-disc ps-5">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        
        <form method="POST" action="<?php echo e(route('emergency_services.store')); ?>">
            <?php echo csrf_field(); ?>

            
            <div class="mb-4">
                <label class="block font-semibold mb-1">📛 الاسم</label>
                <input type="text" name="name" class="w-full border-gray-300 rounded px-4 py-2" required>
            </div>

            
            <div class="mb-4">
                <label class="block font-semibold mb-1">🏙️ المدينة</label>
                <input type="text" name="city" class="w-full border-gray-300 rounded px-4 py-2" required>
            </div>

            
            <div class="mb-4">
                <label class="block font-semibold mb-1">🛠️ نوع المركز</label>
                <select name="type" class="w-full border-gray-300 rounded px-4 py-2" required>
                    <option value="رافعة">رافعة</option>
                    <option value="مركز صيانة">مركز صيانة</option>
                </select>
            </div>

            
            <div class="mb-4">
                <label class="block font-semibold mb-1">🔍 ابحث عن الموقع</label>
                <input type="text" id="searchBox" placeholder="أدخل اسم مدينة أو عنوان..."
                       class="w-full border-gray-300 rounded px-4 py-2">
                <button type="button" id="searchBtn"
                        class="mt-2 bg-green-500 hover:bg-green-600 text-white font-bold px-4 py-2 rounded shadow">
                    🔍 بحث
                </button>
            </div>

            
            <div class="mb-4">
                <label class="block font-semibold mb-2">🌍 حدد الموقع على الخريطة</label>
                <div id="map" class="w-full h-80 rounded-lg shadow border mb-3"></div>

                
                <button type="button" id="locateBtn"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-bold px-4 py-2 rounded shadow">
                    📍 استخدم موقعي الحالي
                </button>
            </div>

            
            <div class="mb-4">
                <label class="block font-semibold mb-1">📍 خط العرض (Latitude)</label>
                <input type="text" id="lat" name="lat" class="w-full border-gray-300 rounded px-4 py-2" readonly required>
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1">📍 خط الطول (Longitude)</label>
                <input type="text" id="lng" name="lng" class="w-full border-gray-300 rounded px-4 py-2" readonly required>
            </div>

<div class="mb-4">
    <label class="block font-semibold mb-1">📝 تفاصيل الخدمة</label>
    <textarea name="description" rows="3" class="w-full border-gray-300 rounded px-4 py-2"></textarea>
</div>


<div class="mb-4">
    <label class="block font-semibold mb-1">📞 رقم الهاتف</label>
    <input type="text" name="phone" class="w-full border-gray-300 rounded px-4 py-2">
</div>


<div class="mb-4">
    <label class="block font-semibold mb-1">💬 رقم الواتساب</label>
    <input type="text" name="whatsapp" class="w-full border-gray-300 rounded px-4 py-2">
</div>


<div class="mb-4">
    <label class="block font-semibold mb-1">📧 البريد الإلكتروني</label>
    <input type="email" name="email" class="w-full border-gray-300 rounded px-4 py-2">
</div>

            
            <button type="submit" class="w-full bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600">
                ✅ إضافة المركز
            </button>
        </form>
    </div>

    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const map = L.map('map').setView([34.8021, 38.9968], 7); // افتراضي سوريا
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; Delni.co'
            }).addTo(map);

            let marker;

            function setMarker(lat, lng) {
                if (marker) map.removeLayer(marker);
                marker = L.marker([lat, lng]).addTo(map);
                document.getElementById('lat').value = lat;
                document.getElementById('lng').value = lng;
            }

            // 📍 تحديد بالنقر
            map.on('click', function (e) {
                setMarker(e.latlng.lat.toFixed(6), e.latlng.lng.toFixed(6));
            });

            // 📍 استخدم موقعي
            document.getElementById('locateBtn').addEventListener('click', function () {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (pos) {
                        const lat = pos.coords.latitude.toFixed(6);
                        const lng = pos.coords.longitude.toFixed(6);
                        setMarker(lat, lng);
                        map.setView([lat, lng], 15);
                    }, () => alert("⚠️ تعذر الحصول على الموقع."));
                } else {
                    alert("⚠️ المتصفح لا يدعم تحديد الموقع.");
                }
            });

            // 🔍 البحث عن موقع (Geocoding باستخدام Nominatim)
            document.getElementById('searchBtn').addEventListener('click', function () {
                const query = document.getElementById('searchBox').value;
                if (!query) return alert("⚠️ أدخل اسم مدينة أو عنوان أولاً.");

                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            const lat = parseFloat(data[0].lat).toFixed(6);
                            const lng = parseFloat(data[0].lon).toFixed(6);
                            setMarker(lat, lng);
                            map.setView([lat, lng], 14);
                        } else {
                            alert("❌ لم يتم العثور على موقع.");
                        }
                    })
                    .catch(() => alert("⚠️ خطأ في البحث عن الموقع."));
            });
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /home/delni_user/delni/resources/views/emergency_services/create.blade.php ENDPATH**/ ?>