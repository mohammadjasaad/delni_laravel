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
    <div class="max-w-7xl mx-auto px-4 py-8">

        
        <h1 class="text-3xl font-bold text-center text-yellow-600 mb-8">
            🚖 <?php echo e(__('messages.delni_taxi')); ?>

        </h1>

        
        <div id="map" class="w-full h-[400px] rounded shadow mb-8"></div>

        
        <?php if(isset($nearestDriver)): ?>
            <div class="bg-white p-4 rounded shadow mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">🚗 أقرب سائق: <?php echo e($nearestDriver->name); ?></h2>
                <p class="text-gray-600">رقم السيارة: <?php echo e($nearestDriver->car_number); ?></p>
                <p class="text-gray-600">المسافة: <?php echo e($nearestDriver->distance); ?> كم</p>
            </div>
        <?php endif; ?>

        
        <div class="flex flex-wrap justify-center gap-4 mb-8">
            <a href="<?php echo e(route('order.taxi')); ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded shadow">
                🚕 اطلب سيارة الآن
            </a>
            <a href="<?php echo e(route('drivers.map')); ?>" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow">
                🗺️ خريطة السائقين
            </a>
            <a href="<?php echo e(route('driver.login')); ?>" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded shadow">
                👨‍✈️ دخول السائق
            </a>
            <a href="<?php echo e(route('driver.dashboard')); ?>" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow">
                🛠️ لوحة تحكم السائق
            </a>
        </div>

        
        <?php if(auth()->guard()->check()): ?>
            <?php if($activeOrder): ?>
                <div class="bg-white p-4 rounded shadow mb-10">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">🕒 حالة الطلب الحالية</h3>
                    <p class="text-gray-700">السائق: <strong><?php echo e($activeOrder->driver_name); ?></strong></p>
                    <p class="text-gray-700">الحالة: <strong><?php echo e($activeOrder->status); ?></strong></p>
                    <a href="<?php echo e(route('order.status', ['id' => $activeOrder->id])); ?>"
                       class="mt-4 inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow">
                        🔍 تفاصيل الطلب
                    </a>
                </div>
            <?php endif; ?>
        <?php endif; ?>

    </div>

    
    <script>
        var map = L.map('map').setView([<?php echo e($userLat ?? 33.5); ?>, <?php echo e($userLng ?? 36.3); ?>], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // ✅ موقع المستخدم
        L.marker([<?php echo e($userLat ?? 33.5); ?>, <?php echo e($userLng ?? 36.3); ?>])
            .addTo(map)
            .bindPopup("📍 موقعك الحالي")
            .openPopup();

        // ✅ السائقين على الخريطة
        <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            L.marker([<?php echo e($driver->lat); ?>, <?php echo e($driver->lng); ?>], {
                icon: L.icon({
                    iconUrl: 'https://cdn-icons-png.flaticon.com/512/2593/2593331.png',
                    iconSize: [30, 30],
                })
            })
            .addTo(map)
            .bindPopup("<strong><?php echo e($driver->name); ?></strong><br>🚗 <?php echo e($driver->car_number); ?>");
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php /**PATH /home/delni_user/delni/resources/views/taxi/delni-taxi.blade.php ENDPATH**/ ?>