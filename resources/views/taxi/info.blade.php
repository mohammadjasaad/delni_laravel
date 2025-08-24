<x-main-layout title="Delni Taxi">
    <div class="max-w-4xl mx-auto px-4 py-10 text-center">
        <img src="{{ asset('images/delni_taxi_landing.png') }}" class="mx-auto mb-8 rounded-lg shadow-lg" alt="Delni Taxi">

        <h1 class="text-3xl font-bold text-yellow-600 mb-4">🚖 خدمة Delni Taxi</h1>
        <p class="text-lg text-gray-700 mb-6">
            اطلب سيارة بكل سهولة عبر تطبيق Delni App! الخدمة متاحة على مدار الساعة.
        </p>

        {{-- ✅ روابط تحميل التطبيق --}}
        <div class="flex justify-center gap-6 mt-6">
            <a href="#" class="bg-black text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-800 transition">
                📱 تحميل للأندرويد
            </a>
            <a href="#" class="bg-black text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-800 transition">
                🍎 تحميل للآيفون
            </a>
        </div>

        {{-- ✅ كود QR --}}
        <div class="mt-10">
            <p class="text-gray-600 mb-2">امسح الكود لتحميل التطبيق:</p>
            <img src="{{ asset('images/delni_taxi_qr.png') }}" alt="QR Code" class="mx-auto w-40">
        </div>
    </div>
</x-main-layout>
