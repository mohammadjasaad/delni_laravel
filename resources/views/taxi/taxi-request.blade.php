<x-main-layout title="🚕 طلب تاكسي">

    <div class="max-w-xl mx-auto mt-10 bg-white shadow rounded p-6 space-y-6 text-right">

        <h1 class="text-2xl font-bold text-yellow-600">🚕 اطلب سيارة الآن</h1>
        <p class="text-gray-700 mb-4">يرجى تعبئة البيانات التالية لإرسال طلب تاكسي:</p>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded text-center">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('taxi.request') }}">
            @csrf

            {{-- ✅ اسم المستخدم --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">اسمك:</label>
                <input type="text" name="user_name" required class="w-full border rounded px-3 py-2">
            </div>

            {{-- ✅ موقع الانطلاق --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">موقع الانطلاق:</label>
                <input type="text" name="pickup_location" required class="w-full border rounded px-3 py-2">
            </div>

            {{-- ✅ موقع الوجهة --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">وجهتك:</label>
                <input type="text" name="destination" required class="w-full border rounded px-3 py-2">
            </div>

            {{-- ✅ إرسال --}}
            <div class="text-center mt-6">
                <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded hover:bg-yellow-600 transition">
                    🚖 أرسل الطلب
                </button>
            </div>
        </form>

    </div>

</x-main-layout>
