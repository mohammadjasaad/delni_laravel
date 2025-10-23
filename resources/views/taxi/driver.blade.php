<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-6">

        {{-- ✅ العنوان --}}
        <h1 class="text-3xl font-bold text-center text-yellow-600 mb-8">
            👨‍✈️ صفحة السائق | Driver
        </h1>

        {{-- ✅ الخيارات الرئيسية --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

            {{-- تسجيل الدخول --}}
            <a href="{{ route('driver.login') }}"
               class="flex flex-col items-center justify-center bg-green-600 hover:bg-green-700 text-white p-6 rounded-xl shadow-md transition transform hover:scale-105">
                <div class="text-5xl mb-3">🔑</div>
                <h3 class="text-xl font-bold mb-2">تسجيل الدخول</h3>
                <p>ادخل إلى حسابك</p>
            </a>

            {{-- لوحة التحكم --}}
            <a href="{{ route('driver.dashboard') }}"
               class="flex flex-col items-center justify-center bg-blue-500 hover:bg-blue-600 text-white p-6 rounded-xl shadow-md transition transform hover:scale-105">
                <div class="text-5xl mb-3">🛠️</div>
                <h3 class="text-xl font-bold mb-2">لوحة التحكم</h3>
                <p>إدارة الطلبات وتحديث الحالة</p>
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
