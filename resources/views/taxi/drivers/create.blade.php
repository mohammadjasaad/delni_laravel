<x-main-layout title="إضافة سائق جديد">
    <div class="max-w-xl mx-auto bg-white shadow p-6 rounded mt-6 text-right">
        <h1 class="text-2xl font-bold text-yellow-600 mb-4 text-center">🚕 إضافة سائق جديد</h1>

        {{-- ✅ عرض الأخطاء --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ✅ نموذج إضافة السائق --}}
        <form method="POST" action="{{ route('drivers.store') }}">
            @csrf

            {{-- الاسم --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">اسم السائق:</label>
                <input type="text" name="name" class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>

            {{-- رقم السيارة --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">رقم السيارة:</label>
                <input type="text" name="car_number" class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>

            {{-- الحالة --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">حالة السائق:</label>
                <select name="status" class="w-full border border-gray-300 rounded px-3 py-2">
                    <option value="متاح">🟢 متاح</option>
                    <option value="مشغول">🔴 مشغول</option>
                    <option value="غير متصل">⚪ غير متصل</option>
                </select>
            </div>

            {{-- خط العرض --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">خط العرض (Latitude):</label>
                <input type="text" name="lat" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="مثال: 33.5138">
            </div>

            {{-- خط الطول --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">خط الطول (Longitude):</label>
                <input type="text" name="lon" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="مثال: 36.2765">
            </div>

            {{-- زر الإرسال --}}
            <div class="text-center">
                <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded hover:bg-yellow-600 transition">
                    💾 حفظ السائق
                </button>
            </div>
        </form>
    </div>
</x-main-layout>
