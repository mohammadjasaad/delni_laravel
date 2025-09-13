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
    <div class="max-w-4xl mx-auto p-4 sm:p-6 md:p-10 mt-6 bg-white rounded-lg shadow-md">
        <h2 class="text-xl sm:text-2xl font-bold text-center text-yellow-600 mb-6">👨‍✈️ لوحة تحكم السائق</h2>

        
        <?php if(session('success')): ?>
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 text-center text-sm sm:text-base">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        
        <div class="text-gray-800 space-y-3 sm:space-y-4 text-sm sm:text-base">
            <div><strong>👤 الاسم:</strong> <?php echo e($driver->name); ?></div>
            <div><strong>🚗 رقم السيارة:</strong> <?php echo e($driver->car_number); ?></div>
            <div>
                <strong>📍 الحالة:</strong>
                <span class="font-semibold 
                    <?php echo e($driver->status === 'متاح' ? 'text-green-600' : 
                       ($driver->status === 'مشغول' ? 'text-red-600' : 'text-gray-500')); ?>">
                    <?php echo e($driver->status ?? 'غير معروف'); ?>

                </span>
            </div>
            <div>
                <strong>🌍 الموقع:</strong> <?php echo e($driver->latitude ?? 'غير محدد'); ?>, <?php echo e($driver->longitude ?? 'غير محدد'); ?>

            </div>
        </div>

        
        <div class="mt-6">
            <form method="POST" action="<?php echo e(route('driver.status', $driver->id)); ?>" class="space-y-3">
                <?php echo csrf_field(); ?>
                <label for="status" class="block font-semibold text-gray-700">🛠️ تغيير الحالة:</label>
                <select name="status" id="status"
                        class="w-full p-2 border border-gray-300 rounded text-sm sm:text-base">
                    <option value="متاح" <?php echo e($driver->status === 'متاح' ? 'selected' : ''); ?>>✅ متاح</option>
                    <option value="مشغول" <?php echo e($driver->status === 'مشغول' ? 'selected' : ''); ?>>🚕 مشغول</option>
                    <option value="غير متصل" <?php echo e($driver->status === 'غير متصل' ? 'selected' : ''); ?>>❌ غير متصل</option>
                </select>
                <button type="submit"
                        class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded w-full sm:w-auto">
                    💾 حفظ التغيير
                </button>
            </form>
        </div>

        
        <div class="mt-6">
            <form method="POST" action="<?php echo e(route('driver.location', $driver->id)); ?>">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="lat" id="lat">
                <input type="hidden" name="lon" id="lon">

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-full">
                    🔄 تحديث موقعي الجغرافي الحالي
                </button>
            </form>
        </div>


<?php if($driver->taxiOrders && count($driver->taxiOrders) > 0): ?>
    <div class="mt-10 bg-gray-100 p-4 rounded shadow text-sm sm:text-base">
        <h3 class="text-lg font-bold text-yellow-700 mb-4 text-center">📋 الطلبات الجارية</h3>

        <?php $__currentLoopData = $driver->taxiOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activeOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="border border-gray-300 rounded p-4 mb-4 bg-white">
                <p><strong>👤 الراكب:</strong> <?php echo e($activeOrder->user_name); ?></p>
                <p><strong>🗺️ من:</strong> <?php echo e($activeOrder->pickup_latitude); ?>, <?php echo e($activeOrder->pickup_longitude); ?></p>
                <p><strong>🔁 الحالة:</strong> <?php echo e($activeOrder->status); ?></p>

                <div class="mt-3 flex gap-2">
                    <a href="<?php echo e(route('driver.chat', $activeOrder->id)); ?>"
                       class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded">
                        💬 المحادثة مع الراكب
                    </a>
                    <a href="<?php echo e(route('trip.completed', ['order' => $activeOrder->id])); ?>"
                       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        ✅ إنهاء الرحلة
                    </a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>

        
        <?php if($order): ?>
        <div class="mt-8 bg-gray-100 p-4 rounded shadow text-sm sm:text-base">
            <h3 class="text-lg font-bold text-yellow-700 mb-2 text-center">🚖 تفاصيل الطلب الحالي</h3>
            <p><strong>👤 الراكب:</strong> <?php echo e($order->user_name); ?></p>
            <p><strong>📍 نقطة الانطلاق:</strong> <?php echo e($order->pickup_latitude); ?>, <?php echo e($order->pickup_longitude); ?></p>
            <p><strong>🔁 الحالة:</strong> <?php echo e($order->status); ?></p>
            <div class="mt-4 flex flex-col sm:flex-row gap-3 justify-center">
                <a href="<?php echo e(route('trip.completed')); ?>"
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-center">
                    ✅ إنهاء الرحلة
                </a>
                <a href="<?php echo e(route('home')); ?>"
                   class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-center">
                    ❌ إلغاء الطلب
                </a>
            </div>
        </div>
        <?php endif; ?>

        
        <?php if($order): ?>
        <div class="mt-8 bg-white border p-4 rounded shadow">
            <h3 class="text-lg font-bold mb-3">💬 المحادثة مع الراكب</h3>
            <div id="chatBox" class="h-64 overflow-y-auto border p-2 rounded mb-3 bg-gray-50 text-sm sm:text-base"></div>
            <form id="chatForm" class="flex flex-col sm:flex-row gap-2">
                <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">
                <input type="hidden" name="sender" value="driver">
                <input type="text" name="message" placeholder="اكتب رسالتك..." class="flex-1 border rounded px-3 py-2"
                       required>
                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">إرسال</button>
            </form>
        </div>
        <?php endif; ?>

        
        <div class="mt-6 text-center">
            <a href="<?php echo e(route('drivers.index')); ?>" class="text-sm text-gray-600 hover:underline">
                ⬅️ العودة إلى قائمة السائقين
            </a>
        </div>
    </div>

    
    <script>
        // تحديد الموقع
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                document.getElementById('lat').value = position.coords.latitude;
                document.getElementById('lon').value = position.coords.longitude;
            });
        }

        // تحميل الرسائل
        async function loadMessages() {
            const res = await fetch("<?php echo e(route('driver.message.fetch')); ?>");
            const messages = await res.json();
            const chatBox = document.getElementById("chatBox");
            chatBox.innerHTML = "";
            messages.forEach(msg => {
                const msgDiv = document.createElement("div");
                msgDiv.className = "mb-2";
                msgDiv.innerHTML = `<strong>${msg.sender === 'driver' ? '👨‍✈️ أنت' : '👤 الراكب'}:</strong> ${msg.message}`;
                chatBox.appendChild(msgDiv);
            });
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        document.getElementById("chatForm").addEventListener("submit", async function (e) {
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
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /home/delni_user/delni/resources/views/taxi/drivers/panel.blade.php ENDPATH**/ ?>