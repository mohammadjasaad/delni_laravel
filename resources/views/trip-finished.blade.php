<x-main-layout title="🚖 تم إنهاء الرحلة بنجاح">
    <div class="max-w-2xl mx-auto px-4 py-12 text-center space-y-6">

        <h1 class="text-3xl font-bold text-green-600">✅ وصلت بسلام!</h1>
        <p class="text-lg text-gray-700">شكرًا لاستخدامك Delni Taxi. نأمل أن تكون تجربتك ممتازة.</p>

        {{-- بيانات السائق --}}
        <div class="bg-white shadow rounded p-4 text-center space-y-2">
            <h2 class="text-xl font-semibold text-yellow-600">معلومات السائق</h2>
            <p><strong>الاسم:</strong> <span id="driverName"></span></p>
            <p><strong>السيارة:</strong> <span id="driverCar"></span></p>
            <p><strong>رقم الهاتف:</strong> <span id="driverPhone"></span></p>
        </div>

        {{-- التقييم (إن وُجد) --}}
        <div id="ratingSection" class="hidden bg-gray-100 rounded p-4">
            <h3 class="text-lg font-semibold mb-2 text-gray-800">⭐️ تقييمك للسائق:</h3>
            <p id="userRatingText" class="text-gray-700 mb-1"></p>
            <p id="userRatingStars" class="text-yellow-500 text-xl"></p>
        </div>

        <div class="flex justify-center gap-4 mt-6">
            <a href="{{ route('home') }}" class="bg-gray-700 text-white px-6 py-2 rounded hover:bg-gray-800">
                العودة للرئيسية
            </a>
            <a href="{{ route('taxi.order.status') }}" class="bg-yellow-500 text-white px-6 py-2 rounded hover:bg-yellow-600">
                🚕 طلب رحلة جديدة
            </a>
        </div>
    </div>

    <script>
        // تحميل بيانات السائق
        const driver = JSON.parse(localStorage.getItem('selectedDriver'));
        if (driver) {
            document.getElementById('driverName').textContent = driver.name;
            document.getElementById('driverCar').textContent = driver.car;
            document.getElementById('driverPhone').textContent = driver.phone;
        }

        // تحميل التقييم إن وُجد
        const ratingText = localStorage.getItem('ratingText');
        const ratingStars = localStorage.getItem('ratingStars');

        if (ratingText || ratingStars) {
            document.getElementById("ratingSection").classList.remove("hidden");

            if (ratingText) {
                document.getElementById("userRatingText").textContent = `"${ratingText}"`;
            }

            if (ratingStars) {
                document.getElementById("userRatingStars").textContent = "★".repeat(parseInt(ratingStars));
            }
        }

        // تنظيف البيانات بعد الوصول النهائي
        localStorage.removeItem('selectedDriver');
        localStorage.removeItem('ratingText');
        localStorage.removeItem('ratingStars');
    </script>
</x-main-layout>
