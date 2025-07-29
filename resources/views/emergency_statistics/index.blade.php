<x-app-layout>
    <div class="max-w-5xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold text-center text-yellow-600 mb-8">📊 إحصائيات الطوارئ</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
            <div class="bg-white p-6 rounded shadow">
                <p class="text-lg text-gray-600 mb-2">📋 عدد البلاغات</p>
                <p class="text-3xl font-bold text-red-600">{{ $totalReports }}</p>
            </div>
            <div class="bg-white p-6 rounded shadow">
                <p class="text-lg text-gray-600 mb-2">🏥 عدد مراكز الطوارئ</p>
                <p class="text-3xl font-bold text-yellow-600">{{ $totalServices }}</p>
            </div>
            <div class="bg-white p-6 rounded shadow">
                <p class="text-lg text-gray-600 mb-2">🏙️ أكثر المدن نشاطًا</p>
                @foreach ($topCities as $city)
                    <p class="font-bold text-gray-800">{{ $city->city }} ({{ $city->count }})</p>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
