
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
    <div class="max-w-3xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-yellow-600 mb-6 text-center">👁️ تفاصيل مركز الطوارئ</h1>

        
        <div class="bg-white rounded-lg shadow p-6 space-y-4 text-gray-800">
            <div><strong>📛 الاسم:</strong> <?php echo e($service->name); ?></div>
            <div><strong>🏙️ المدينة:</strong> <?php echo e($service->city); ?></div>
            <div><strong>🛠️ النوع:</strong> <?php echo e($service->type); ?></div>
            <div><strong>📌 الإحداثيات:</strong> <?php echo e($service->lat); ?>, <?php echo e($service->lng); ?></div>

            <?php if($service->description): ?>
                <div><strong>📝 تفاصيل:</strong> <?php echo e($service->description); ?></div>
            <?php endif; ?>
            <?php if($service->phone): ?>
                <div><strong>📞 هاتف:</strong> <a href="tel:<?php echo e($service->phone); ?>" class="text-blue-600"><?php echo e($service->phone); ?></a></div>
            <?php endif; ?>
            <?php if($service->whatsapp): ?>
                <div><strong>💬 واتساب:</strong> <a href="https://wa.me/<?php echo e($service->whatsapp); ?>" target="_blank" class="text-green-600"><?php echo e($service->whatsapp); ?></a></div>
            <?php endif; ?>
            <?php if($service->email): ?>
                <div><strong>📧 بريد:</strong> <a href="mailto:<?php echo e($service->email); ?>" class="text-purple-600"><?php echo e($service->email); ?></a></div>
            <?php endif; ?>
        </div>

        
        <div class="mt-6">
            <h2 class="text-lg font-semibold mb-2">🌍 الموقع والمراكز القريبة</h2>
            <div id="map" class="w-full h-[400px] rounded shadow"></div>
        </div>

        
        <div class="text-center mt-8">
            <a href="<?php echo e(route('emergency_services.index')); ?>" 
               class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded text-gray-700">
                ⬅️ عودة إلى القائمة
            </a>
        </div>
    </div>

    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const map = L.map('map').setView([<?php echo e($service->lat); ?>, <?php echo e($service->lng); ?>], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; Delni.co'
            }).addTo(map);

            // ✅ marker للمركز الحالي
            L.marker([<?php echo e($service->lat); ?>, <?php echo e($service->lng); ?>], {
                icon: L.icon({
                    iconUrl: 'https://maps.gstatic.com/mapfiles/ms2/micons/red-dot.png',
                    iconSize: [32, 32]
                })
            }).addTo(map)
                .bindPopup("<strong><?php echo e($service->name); ?></strong><br><?php echo e($service->city); ?> (المركز الحالي)")
                .openPopup();

            // ✅ markers للمراكز القريبة
            const nearby = <?php echo json_encode($nearby, 15, 512) ?>;
            nearby.forEach(p => {
                if (p.lat && p.lng) {
                    L.marker([p.lat, p.lng]).addTo(map)
                        .bindPopup(`
                            <strong>${p.name}</strong><br>
                            ${p.city ?? ''} - ${p.type ?? ''}<br>
                            <a href='/emergency-services/${p.id}' class='text-blue-600 underline'>👁️ عرض</a>
                        `);
                }
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
<?php /**PATH /home/delni_user/delni/resources/views/emergency_services/show.blade.php ENDPATH**/ ?>