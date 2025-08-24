<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 py-10" dir="rtl">
        <h1 class="text-3xl font-bold text-yellow-600 mb-4">🛠️ خدمات دلني</h1>
        <p class="text-gray-700 mb-6">هذه صفحة مبدئية للخدمات. عدّل المحتوى كما تشاء.</p>

        @php
            $urlEmergency = \Route::has('emergency_services.index')
                ? route('emergency_services.index')
                : url('/emergency-services');

            $urlTaxi = \Route::has('taxi.landing')
                ? route('taxi.landing')
                : (\Route::has('delni.taxi') ? route('delni.taxi') : url('/delni-taxi'));

            $urlContact = \Route::has('contact') ? route('contact') : url('/contact');
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ $urlEmergency }}" class="block bg-white rounded-lg shadow p-5 hover:shadow-lg transition">
                <h2 class="font-bold text-lg mb-2">🆘 دلني عاجل</h2>
                <p class="text-sm text-gray-600">مراكز طوارئ، رافعات، صيانة الطريق.</p>
            </a>

            <a href="{{ $urlTaxi }}" class="block bg-white rounded-lg shadow p-5 hover:shadow-lg transition">
                <h2 class="font-bold text-lg mb-2">🚕 Delni Taxi</h2>
                <p class="text-sm text-gray-600">اطلب تاكسي وخدمات السائقين.</p>
            </a>

            <a href="{{ $urlContact }}" class="block bg-white rounded-lg shadow p-5 hover:shadow-lg transition">
                <h2 class="font-bold text-lg mb-2">📞 اتصل بنا</h2>
                <p class="text-sm text-gray-600">نحن هنا للمساعدة.</p>
            </a>
        </div>
    </div>
</x-app-layout>
