<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold text-yellow-600 text-center mb-8">📊 إحصائيات مراكز الطوارئ والبلاغات</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <div class="bg-white p-6 rounded shadow text-center">
                <h2 class="text-xl font-bold text-gray-800">🔧 عدد مراكز الطوارئ</h2>
                <p class="text-3xl text-yellow-600 font-bold mt-2">{{ $totalCenters }}</p>
            </div>
            <div class="bg-white p-6 rounded shadow text-center">
                <h2 class="text-xl font-bold text-gray-800">🚨 عدد البلاغات</h2>
                <p class="text-3xl text-red-600 font-bold mt-2">{{ $totalReports }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-bold text-gray-800 mb-4">🏙️ المدن الأكثر تواجدًا للمراكز</h3>
                <ul class="space-y-2">
                    @foreach($topCities as $city)
                        <li class="flex justify-between text-gray-700">
                            <span>📍 {{ $city->city }}</span>
                            <span class="font-semibold">{{ $city->total }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-bold text-gray-800 mb-4">🛠️ أكثر أنواع المراكز انتشارًا</h3>
                <ul class="space-y-2">
                    @foreach($topTypes as $type)
                        <li class="flex justify-between text-gray-700">
                            <span>🔧 {{ $type->type }}</span>
                            <span class="font-semibold">{{ $type->total }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="bg-white p-6 rounded shadow mt-10">
            <h3 class="text-lg font-bold text-gray-800 mb-4">🚨 أكثر المدن التي ورد منها بلاغات</h3>
            <ul class="space-y-2">
                @foreach($reportCities as $report)
                    <li class="flex justify-between text-gray-700">
                        <span>🏙️ {{ $report->city }}</span>
                        <span class="font-semibold">{{ $report->total }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>
