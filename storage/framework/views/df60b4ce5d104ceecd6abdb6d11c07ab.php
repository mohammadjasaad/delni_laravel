<?php if (isset($component)) { $__componentOriginal66d7cfd03cd343304d81fe1e21646540 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal66d7cfd03cd343304d81fe1e21646540 = $attributes; } ?>
<?php $component = App\View\Components\MainLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('main-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\MainLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => '🚖 طلبك قيد التنفيذ']); ?>
    <div class="max-w-3xl mx-auto px-4 py-8 space-y-6">

        <h2 class="text-2xl font-bold text-center text-yellow-600">🚖 تم تحديد أقرب سائق لك</h2>

        <div class="bg-white shadow rounded p-4 space-y-2 text-center">
            <p><strong>الاسم:</strong> <span id="driverName" class="font-bold text-lg text-gray-700"></span></p>
            <p><strong>رقم السيارة:</strong> <span id="driverCar" class="text-blue-600"></span></p>
            <p><strong>رقم الهاتف:</strong> <span id="driverPhone" class="text-blue-600"></span></p>
        </div>

        <div class="h-72 rounded overflow-hidden shadow" id="miniMap"></div>

        <div class="flex justify-center gap-4">
            <button onclick="contactDriver()" class="bg-blue-600 text-white px-4 py-2 rounded">
                تواصل مع السائق
            </button>
            <button onclick="showRatingForm()" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                تقييم السائق
            </button>
            <button onclick="cancelOrder()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                إلغاء الطلب
            </button>
        </div>

        <div id="ratingForm" class="hidden bg-gray-100 p-4 rounded space-y-3">
            <h3 class="text-lg font-semibold text-gray-700 text-center">⭐️ قيّم تجربتك مع السائق</h3>

            <div class="flex justify-center space-x-2 rtl:space-x-reverse">
                <template x-for="star in 5">
                    <span @click="rating = star"
                        :class="rating >= star ? 'text-yellow-500' : 'text-gray-300'"
                        class="text-3xl cursor-pointer">★</span>
                </template>
            </div>

            <textarea id="ratingText" class="w-full border border-gray-300 rounded p-2" placeholder="...أخبرنا عن تجربتك"></textarea>

            <div class="text-center">
                <button onclick="submitRating()" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                    إرسال التقييم
                </button>
            </div>
        </div>

    </div>

    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const driver = JSON.parse(localStorage.getItem("selectedDriver"));

        if (!driver) {
            alert("🚫 لا يوجد طلب نشط.");
            window.location.href = "<?php echo e(route('home')); ?>";
        }

        document.getElementById("driverName").textContent = driver.name;
        document.getElementById("driverCar").textContent = driver.car;
        document.getElementById("driverPhone").textContent = driver.phone;

        const map = L.map('miniMap').setView([driver.lat, driver.lon], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const taxiIcon = L.icon({
            iconUrl: '/images/taxi-icon.png',
            iconSize: [38, 38],
            iconAnchor: [19, 38],
        });

        L.marker([driver.lat, driver.lon], { icon: taxiIcon })
            .addTo(map)
            .bindPopup("🚖 السائق هنا")
            .openPopup();

        function cancelOrder() {
            if (confirm("❗ هل أنت متأكد من إلغاء الطلب؟")) {
                localStorage.removeItem("selectedDriver");
                window.location.href = "<?php echo e(route('home')); ?>";
            }
        }

        function contactDriver() {
            alert(`📞 جاري الاتصال بـ ${driver.name} على الرقم: ${driver.phone}`);
            // يمكن فتح WhatsApp أو رابط اتصال لاحقًا
        }

        function showRatingForm() {
            document.getElementById("ratingForm").classList.remove("hidden");
        }

        function submitRating() {
            const text = document.getElementById("ratingText").value;
            const rating = 5; // يمكن ربطها لاحقًا بالنجوم المختارة
            alert(`✅ تم إرسال تقييمك بـ ${rating} نجوم\n"${text}"`);
            document.getElementById("ratingForm").classList.add("hidden");

            // ملاحظة: يمكنك لاحقًا إرسال البيانات إلى السيرفر باستخدام Fetch/AJAX
        }
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
<?php /**PATH /home/delni_user/delni/resources/views/order-taxi.blade.php ENDPATH**/ ?>