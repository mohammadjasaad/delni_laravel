{{-- resources/views/admin/emergency_reports/dashboard.blade.php --}}
<x-app-layout :isAdmin="true">
    <div class="max-w-7xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold text-yellow-600 mb-8 text-center">📊 لوحة إحصائيات الطوارئ</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <p class="text-sm text-gray-500">📌 عدد المراكز</p>
                <p class="text-2xl font-bold text-blue-700">{{ $totalCenters }}</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow text-center">
                <p class="text-sm text-gray-500">🚨 عدد البلاغات</p>
                <p class="text-2xl font-bold text-red-600">{{ $totalReports }}</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow text-center">
                <p class="text-sm text-gray-500">🕒 بلاغات جديدة</p>
                <p class="text-2xl font-bold text-yellow-500">{{ $newReports }}</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow text-center">
                <p class="text-sm text-gray-500">🔧 بلاغات قيد المعالجة</p>
                <p class="text-2xl font-bold text-blue-500">{{ $processingReports }}</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow text-center">
                <p class="text-sm text-gray-500">✅ بلاغات تم حلها</p>
                <p class="text-2xl font-bold text-green-600">{{ $resolvedReports }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-bold mb-4 text-gray-700">🏙️ المدن الأكثر بلاغاً</h2>
            <ul class="space-y-2">
                @forelse ($topCities as $city)
                    <li class="flex justify-between border-b pb-2">
                        <span>{{ $city->city }}</span>
                        <span class="font-bold text-gray-800">{{ $city->count }} بلاغ</span>
                    </li>
                @empty
                    <li class="text-gray-500">لا توجد بيانات حالياً.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-app-layout>
