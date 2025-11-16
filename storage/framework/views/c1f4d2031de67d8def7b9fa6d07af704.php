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
    <div class="max-w-5xl mx-auto px-4 py-8">

        <h1 class="text-3xl font-bold text-center text-yellow-600 mb-6">
            🚖 <?php echo e(__('messages.delni_taxi')); ?>

        </h1>

        
        <div id="map" class="w-full h-[450px] rounded-lg shadow-md mb-6"></div>

        
        <div class="flex flex-wrap justify-center gap-4 mb-8">
            <button onclick="locateUser()" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                📍 حدد موقعي
            </button>

            <button onclick="findNearestDriver()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                🚗 العثور على أقرب سائق
            </button>

            <a href="#" id="requestRideBtn" onclick="submitTaxiOrder()"
               class="hidden bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded">
                🚕 اطلب سيارة الآن
            </a>
        </div>

        
        <?php if(auth()->guard()->check()): ?>
            <?php if($activeOrder): ?>
                <div class="bg-white p-4 rounded shadow mb-10 border-l-4 border-yellow-500">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">🕒 لديك طلب نشط</h3>
                    <p class="text-gray-700">السائق: <strong><?php echo e($activeOrder->driver_name); ?></strong></p>
                    <p class="text-gray-700">الحالة: <strong><?php echo e($activeOrder->status); ?></strong></p>

                    <a href="<?php echo e(route('taxi.order.status', ['id' => $activeOrder->id])); ?>"
                       class="mt-3 inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow">
                        🔍 متابعة الطلب
                    </a>
                </div>
            <?php endif; ?>
        <?php endif; ?>

    </div>

    
    <script>
        let userMarker, nearestDriverMarker, routeLine;

        var map = L.map('map').setView([<?php echo e($userLat ?? 33.5); ?>, <?php echo e($userLng ?? 36.3); ?>], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
        }).addTo(map);

        let drivers = [
            <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                { id: <?php echo e($driver->id); ?>, name: "<?php echo e($driver->name); ?>", lat: <?php echo e($driver->latitude); ?>, lng: <?php echo e($driver->longitude); ?>, car: "<?php echo e($driver->car_number); ?>" },
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        ];

        drivers.forEach(d => {
            L.marker([d.lat, d.lng], {
                icon: L.icon({ iconUrl: 'https://cdn-icons-png.flaticon.com/512/2593/2593331.png', iconSize: [34, 34] })
            }).addTo(map).bindPopup(`<b>${d.name}</b><br>🚗 ${d.car}`);
        });

        function locateUser() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(pos => {
                    let lat = pos.coords.latitude;
                    let lng = pos.coords.longitude;

                    if (userMarker) map.removeLayer(userMarker);

                    userMarker = L.marker([lat, lng]).addTo(map).bindPopup("📍 موقعك").openPopup();
                    map.setView([lat, lng], 14);
                });
            }
        }

        function submitTaxiOrder() {
            if (!userMarker) {
                alert("📍 الرجاء تحديد موقعك أولاً");
                return;
            }

            let pos = userMarker.getLatLng();

            fetch("<?php echo e(route('taxi.order.store')); ?>", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    user_id: <?php echo e(auth()->check() ? auth()->id() : 'null'); ?>,
                    pickup_latitude: pos.lat,
                    pickup_longitude: pos.lng
                })
            })
            .then(res => res.redirected ? window.location.href = res.url : res.json())
            .then(data => {
                if (data.message) {
                    alert(data.message);
                }
            });
        }

        function findNearestDriver() {
            if (!userMarker) {
                alert("📍 الرجاء تحديد موقعك أولاً");
                return;
            }

            let userPos = userMarker.getLatLng();
            let nearest = null;
            let minDist = Infinity;

            drivers.forEach(driver => {
                let dist = map.distance([driver.lat, driver.lng], [userPos.lat, userPos.lng]);
                if (dist < minDist) {
                    minDist = dist;
                    nearest = driver;
                }
            });

            if (nearest) {
                if (nearestDriverMarker) map.removeLayer(nearestDriverMarker);
                if (routeLine) map.removeLayer(routeLine);

                nearestDriverMarker = L.marker([nearest.lat, nearest.lng]).addTo(map)
                    .bindPopup(`🚗 ${nearest.name}<br>${nearest.car}`)
                    .openPopup();

                routeLine = L.polyline([[nearest.lat, nearest.lng], [userPos.lat, userPos.lng]], { color: 'yellow' }).addTo(map);

                document.getElementById("requestRideBtn").classList.remove("hidden");
            }
        }
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