<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-6">

        {{-- ✅ العنوان --}}
        <h1 class="text-3xl font-bold text-center text-yellow-600 mb-8">
            🚖 صفحة الراكب | Passenger
        </h1>

        {{-- ✅ الخيارات الرئيسية --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

            {{-- طلب رحلة جديدة --}}
            <a href="{{ route('taxi.index') }}"
               class="flex flex-col items-center justify-center bg-yellow-500 hover:bg-yellow-600 text-white p-6 rounded-xl shadow-md transition transform hover:scale-105">
                <div class="text-5xl mb-3">🚕</div>
                <h3 class="text-xl font-bold mb-2">اطلب رحلة جديدة</h3>
                <p>ابحث عن أقرب سائق</p>
            </a>

            {{-- حالة الطلب --}}
            <a href="{{ route('taxi.order.status', ['id' => 1]) }}"
               class="flex flex-col items-center justify-center bg-blue-500 hover:bg-blue-600 text-white p-6 rounded-xl shadow-md transition transform hover:scale-105">
                <div class="text-5xl mb-3">🕒</div>
                <h3 class="text-xl font-bold mb-2">حالة طلبي</h3>
                <p>تتبع رحلتك الحالية</p>
            </a>
        </div>

        {{-- ✅ زر العودة --}}
        <div class="mt-10 text-center">
            <a href="{{ route('delni.taxi') }}"
               class="bg-gray-700 hover:bg-gray-800 text-white px-6 py-3 rounded shadow inline-block">
                ⬅️ العودة إلى البداية
            </a>
        </div>
    </div>
</x-app-layout>
