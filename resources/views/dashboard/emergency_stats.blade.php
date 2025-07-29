<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold text-yellow-600 mb-6 text-center">📊 إحصائيات الطوارئ</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">🔧 عدد مراكز الطوارئ</h2>
                <p class="text-3xl font-bold text-red-600">{{ $totalCenters }}</p>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">📢 عدد البلاغات</h2>
                <p class="text-3xl font-bold text-blue-600">{{ $totalReports }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-md font-semibold text-gray-700 mb-4">🏙️ أكثر المدن نشاطًا</h3>
                <ul class="list-disc list-inside text-gray-800">
                    @foreach($topCities as $city)
                        <li>{{ $city->city }} - {{ $city->total }} مركز</li>
                    @endforeach
                </ul>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-md font-semibold text-gray-700 mb-4">🛠️ أكثر أنواع المراكز</h3>
                <ul class="list-disc list-inside text-gray-800">
                    @foreach($topTypes as $type)
                        <li>{{ $type->type }} - {{ $type->total }} مركز</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
