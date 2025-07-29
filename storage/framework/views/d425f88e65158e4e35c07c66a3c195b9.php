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
    <div class="max-w-6xl mx-auto px-4 py-8">
<h1 class="text-3xl font-bold text-center text-yellow-600 mb-6">
    🆘 <?php echo e(__('دلني عاجل')); ?>

</h1> 
<p class="text-center text-gray-700 mb-6">
    هذه الخدمة تساعدك في العثور على أقرب مركز صيانة سيارات، رافعة، أو خدمة طارئة أثناء الطريق
</p>

        
        <div class="text-center mb-6">
            <a href="<?php echo e(route('emergency_services.create')); ?>" 
               class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded shadow transition">
                ➕ أضف مركز جديد
            </a>
        </div>

        
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <form method="GET" action="<?php echo e(route('emergency.index')); ?>" class="flex flex-wrap gap-4 justify-center items-center">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">🏙️ المدينة</label>
                    <input type="text" name="city" value="<?php echo e(request('city')); ?>"
                           class="border border-gray-300 rounded px-3 py-2" placeholder="دمشق، حلب...">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">🛠️ نوع المركز</label>
                    <select name="type" class="border border-gray-300 rounded px-3 py-2">
                        <option value="">الكل</option>
                        <option value="رافعة" <?php echo e(request('type') == 'رافعة' ? 'selected' : ''); ?>>رافعة</option>
                        <option value="مركز صيانة" <?php echo e(request('type') == 'مركز صيانة' ? 'selected' : ''); ?>>مركز صيانة</option>
                    </select>
                </div>

                <div class="mt-6">
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                        🔍 فلترة
                    </button>
                </div>

                <div class="mt-6">
                    <a href="<?php echo e(route('emergency.index')); ?>"
                       class="text-gray-600 hover:text-black underline text-sm">↩️ إعادة تعيين</a>
                </div>
            </form>
        </div>

        
        <div id="emergencyMap" class="w-full h-[500px] rounded-lg shadow-md mb-10"></div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="bg-white border border-yellow-300 p-4 rounded-lg shadow hover:shadow-lg transition relative">
    <h2 class="text-lg font-bold text-gray-800 mb-1">🔧 <?php echo e($service->name); ?></h2>
    <p class="text-sm text-gray-600">📍 <?php echo e($service->city); ?></p>
    <p class="text-sm text-gray-500">🛠️ النوع: <?php echo e($service->type); ?></p>
    <p class="text-xs text-gray-400 mt-2">📌 الإحداثيات: <?php echo e($service->lat); ?>, <?php echo e($service->lng); ?></p>
    <p id="distance-<?php echo e($service->id); ?>" class="text-xs text-gray-500 mt-1">📏 المسافة: غير معروفة</p>

    <a href="<?php echo e(route('emergency_services.show', $service->id)); ?>"
       class="inline-block mt-3 text-sm text-yellow-600 hover:underline font-semibold">
        👁️ عرض التفاصيل
    </a>

    
    <button onclick="openReportModal(<?php echo e($service->id); ?>)"
        class="block text-red-600 hover:text-red-800 text-sm font-semibold mt-1">
        🚫 أبلغ عن هذا المركز
    </button>

    
    <div class="absolute top-2 end-2 flex gap-3">
        <a href="<?php echo e(route('emergency_services.edit', $service->id)); ?>"
           class="text-blue-600 hover:text-blue-800 font-semibold text-sm">✏️</a>
        <form method="POST" action="<?php echo e(route('emergency_services.destroy', $service->id)); ?>"
              onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذا المركز؟');">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-sm">🗑️</button>
        </form>
    </div>
</div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <div class="text-center my-6">
        <button id="locateBtn" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow">
            📍 حدد موقعي
        </button>
    </div>

    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const map = L.map('emergencyMap').setView([34.8021, 38.9968], 7);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; Delni.co'
            }).addTo(map);

            const urlParams = new URLSearchParams(window.location.search);
            const city = urlParams.get('city') || '';
            const type = urlParams.get('type') || '';

            let markers = [];
            let servicesData = [];

            fetch(`<?php echo e(route('emergency_services.mapData')); ?>?city=${city}&type=${type}`)
                .then(response => response.json())
                .then(data => {
                    servicesData = data;
                    data.forEach(service => {
                        if (service.lat && service.lng) {
                            const marker = L.marker([service.lat, service.lng]).addTo(map);
                            marker.bindPopup(`
                                <strong>🔧 ${service.name}</strong><br>
                                🛠️ النوع: ${service.type}<br>
                                📍 المدينة: ${service.city}<br>
                                📏 المسافة: <span id="popup-distance-${service.id}">غير معروفة</span>
                            `);
                            markers.push({ id: service.id, marker, lat: service.lat, lng: service.lng });
                        }
                    });
                });

            document.getElementById('locateBtn').addEventListener('click', function () {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        const userLat = position.coords.latitude;
                        const userLng = position.coords.longitude;

                        L.marker([userLat, userLng])
                            .addTo(map)
                            .bindPopup("📍 أنت هنا")
                            .openPopup();

                        map.setView([userLat, userLng], 13);

                        servicesData.forEach(service => {
                            const dist = calculateDistance(userLat, userLng, service.lat, service.lng);
                            service.distance = dist;

                            const el = document.getElementById('distance-' + service.id);
                            if (el) el.textContent = `📏 المسافة: ${dist.toFixed(2)} كم`;

                            const popupEl = document.getElementById('popup-distance-' + service.id);
                            if (popupEl) popupEl.textContent = `${dist.toFixed(2)} كم`;
                        });

                        servicesData.sort((a, b) => a.distance - b.distance);

                        const container = document.querySelector('.grid');
                        const cards = Array.from(container.children);

                        const cardMap = {};
                        cards.forEach(card => {
                            const id = card.querySelector('[id^="distance-"]').id.split('-')[1];
                            cardMap[id] = card;
                        });

                        container.innerHTML = '';
                        servicesData.forEach(service => {
                            if (cardMap[service.id]) {
                                container.appendChild(cardMap[service.id]);
                            }
                        });

                    }, function () {
                        alert("فشل في تحديد الموقع.");
                    });
                } else {
                    alert("المتصفح لا يدعم تحديد الموقع الجغرافي.");
                }
            });

            function calculateDistance(lat1, lon1, lat2, lon2) {
                const R = 6371;
                const dLat = (lat2 - lat1) * Math.PI / 180;
                const dLon = (lon2 - lon1) * Math.PI / 180;
                const a = 
                    Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                    Math.sin(dLon / 2) * Math.sin(dLon / 2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                return R * c;
            }
        });
function openReportModal(serviceId) {
    document.getElementById('reportServiceId').value = serviceId;
    document.getElementById('reportModal').classList.remove('hidden');
    document.getElementById('reportModal').classList.add('flex');
}

function closeReportModal() {
    document.getElementById('reportModal').classList.remove('flex');
    document.getElementById('reportModal').classList.add('hidden');
}

    </script>

<div id="reportModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl p-6 max-w-sm w-full">
        <h2 class="text-lg font-bold text-gray-800 mb-4">🚫 تأكيد الإبلاغ</h2>
        <p class="text-sm text-gray-700 mb-4">هل أنت متأكد أنك تريد الإبلاغ عن هذا المركز؟ سيتم مراجعة البلاغ من قبل فريق الدعم.</p>

        <form method="POST" action="<?php echo e(route('emergency_reports.store')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="service_id" id="reportServiceId">

            <textarea name="reason" rows="3" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm mb-4" placeholder="سبب الإبلاغ..."></textarea>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeReportModal()" class="text-gray-600 hover:text-black">❌ إلغاء</button>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold px-4 py-2 rounded">✅ أبلغ</button>
            </div>
        </form>
    </div>
</div>
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
<?php /**PATH /home/delni_user/delni/resources/views/emergency_services/index.blade.php ENDPATH**/ ?>