<x-main-layout title="تم إنهاء الرحلة بنجاح">
    <div class="max-w-3xl mx-auto p-6 bg-white shadow-lg rounded-lg text-center space-y-6 mt-10">

        {{-- ✅ رسالة الشكر --}}
        <h1 class="text-3xl font-extrabold text-green-600">✅ شكراً لاستخدامك Delni Taxi!</h1>
        <p class="text-gray-700 text-lg">تم إنهاء الرحلة بنجاح. نتمنى لك يوماً سعيداً ومليئاً بالراحة.</p>
<div class="text-5xl text-yellow-500 mb-4">⭐️⭐️⭐️⭐️⭐️</div>

        {{-- ✅ معلومات السائق --}}
        <div class="bg-gray-100 p-5 rounded-lg text-right shadow-sm border border-gray-200">
            <h2 class="text-2xl font-semibold text-gray-800 mb-3">🧑‍✈️ معلومات السائق</h2>
            <ul class="space-y-2 text-sm text-gray-700">
                <li><strong>الاسم:</strong> أبو أحمد</li>
                <li><strong>رقم السيارة:</strong> دمشق 123456</li>
            </ul>
        </div>

        {{-- ✅ تنبيه عدم التقييم --}}
        @if(!session('rating_submitted'))
            <div class="bg-yellow-100 text-yellow-800 p-4 rounded-md shadow border border-yellow-300">
                ⚠️ لم تقم بتقييم السائق بعد. يمكنك تقييمه من صفحة <a href="{{ route('order.status') }}" class="underline font-semibold text-yellow-900 hover:text-yellow-700">حالة الطلب</a>.
            </div>
        @endif

        {{-- ✅ خيارات المستخدم --}}
        <div class="flex flex-col sm:flex-row justify-center gap-4 mt-6">
            <a href="{{ route('home') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition duration-200">
                🏠 العودة إلى الرئيسية
            </a>

            <a href="{{ route('delni.taxi') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-2 rounded-lg transition duration-200">
                🚕 طلب تاكسي جديد
            </a>
        </div>

    </div>
</x-main-layout>
