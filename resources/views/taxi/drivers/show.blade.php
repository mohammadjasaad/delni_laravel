<x-app-layout>
    <div class="p-6 max-w-xl mx-auto bg-white rounded shadow mt-10 text-center">
        <h1 class="text-2xl font-bold text-yellow-600 mb-6">🚖 تفاصيل السائق</h1>

        <p>👤 الاسم الكامل: {{ $driver->name }}</p>
        <p>🚗 رقم السيارة: {{ $driver->car_number }}</p>
        <p>📍 الحالة: {{ $driver->status ?? 'غير معروف' }}</p>
        <p>🌍 الإحداثيات: {{ $driver->lat ?? 'غير محدد' }}, {{ $driver->lon ?? 'غير محدد' }}</p>
        <p>⏰ آخر تحديث: {{ $driver->updated_at->diffForHumans() }}</p>

        <div class="mt-6">
            <a href="{{ route('drivers.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-800">
                ⬅️ الرجوع إلى القائمة
            </a>
        </div>
    </div>
</x-app-layout>
