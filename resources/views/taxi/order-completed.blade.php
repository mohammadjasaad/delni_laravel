<x-main-layout title="✅ تم إنهاء الرحلة">

    <div class="max-w-2xl mx-auto mt-12 bg-white p-8 rounded shadow text-center">

        {{-- ✅ عنوان النجاح --}}
        <h1 class="text-3xl font-bold text-green-600 mb-4">🎉 تم إنهاء الرحلة بنجاح</h1>
        <p class="text-gray-700 mb-6">شكرًا لاستخدامك خدمة Delni Taxi. نأمل أن تكون رحلتك مريحة وآمنة.</p>

        {{-- 👨✈️ معلومات السائق --}}
        <div class="bg-gray-50 border rounded p-4 mb-6 text-right">
            <p><strong>👨✈️ السائق:</strong> {{ $driver->name }}</p>
            <p><strong>🚗 رقم السيارة:</strong> {{ $driver->car_number }}</p>
        </div>

        {{-- ⭐ التقييم (إن توفر) --}}
        @if ($rating)
            <div class="bg-yellow-50 border border-yellow-300 rounded p-4 mb-6 text-right">
                <p><strong>⭐ تقييمك:</strong> {{ $rating->rating }} / 5</p>
                @if($rating->comment)
                    <p><strong>💬 ملاحظاتك:</strong> {{ $rating->comment }}</p>
                @endif
            </div>
        @endif

        {{-- 🔘 الأزرار --}}
        <div class="flex flex-col sm:flex-row justify-center gap-4 mt-6">
            <a href="{{ route('home') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded transition">
                🏠 العودة إلى الصفحة الرئيسية
            </a>
            <a href="{{ route('taxi.map') }}"
               class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2 rounded transition">
                🚖 طلب رحلة جديدة
            </a>
        </div>

    </div>

</x-main-layout>
