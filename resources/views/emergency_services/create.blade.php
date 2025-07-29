<x-app-layout>
    <div class="max-w-xl mx-auto mt-10 p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold text-yellow-600 text-center mb-6">➕ أضف مركز طوارئ جديد</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                <ul class="list-disc ps-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('emergency.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block font-semibold mb-1">📛 الاسم</label>
                <input type="text" name="name" class="w-full border-gray-300 rounded px-4 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">🏙️ المدينة</label>
                <input type="text" name="city" class="w-full border-gray-300 rounded px-4 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">🛠️ نوع المركز</label>
                <select name="type" class="w-full border-gray-300 rounded px-4 py-2" required>
                    <option value="رافعة">رافعة</option>
                    <option value="مركز صيانة">مركز صيانة</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">🌍 خط العرض (Latitude)</label>
                <input type="text" name="latitude" class="w-full border-gray-300 rounded px-4 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">🌍 خط الطول (Longitude)</label>
                <input type="text" name="longitude" class="w-full border-gray-300 rounded px-4 py-2" required>
            </div>

            <button type="submit" class="w-full bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600">
                ✅ إضافة المركز
            </button>
        </form>
    </div>
</x-app-layout>
