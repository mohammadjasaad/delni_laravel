<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-10">

        <h1 class="text-3xl font-bold text-yellow-600 text-center mb-10">📊 إحصائيات الموقع</h1>

        {{-- ✅ الإحصائيات الرئيسية --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-10">
            <div class="bg-white rounded shadow p-6 text-center">
                <div class="text-4xl font-bold text-yellow-600">{{ $userCount }}</div>
                <div class="text-gray-700 mt-2">👤 عدد المستخدمين</div>
            </div>
            <div class="bg-white rounded shadow p-6 text-center">
                <div class="text-4xl font-bold text-yellow-600">{{ $adCount }}</div>
                <div class="text-gray-700 mt-2">📢 عدد الإعلانات</div>
            </div>
            <div class="bg-white rounded shadow p-6 text-center">
                <div class="text-4xl font-bold text-yellow-600">{{ $emergencyCount }}</div>
                <div class="text-gray-700 mt-2">🆘 مراكز الطوارئ</div>
            </div>
            <div class="bg-white rounded shadow p-6 text-center">
                <div class="text-4xl font-bold text-yellow-600">{{ $reportCount }}</div>
                <div class="text-gray-700 mt-2">🚨 عدد البلاغات</div>
            </div>
            <div class="bg-white rounded shadow p-6 text-center">
                <div class="text-4xl font-bold text-yellow-600">{{ $driverCount }}</div>
                <div class="text-gray-700 mt-2">🚖 عدد السائقين</div>
            </div>
        </div>

        {{-- ✅ أكثر المدن نشاطًا في الإعلانات --}}
        <div class="bg-white rounded shadow p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">🏙️ أكثر 3 مدن تحتوي إعلانات</h2>
            <ul class="list-disc list-inside text-gray-700">
                @forelse ($topAdCities as $city)
                    <li>{{ $city->city }} - {{ $city->total }} إعلان</li>
                @empty
                    <li>لا توجد بيانات حالياً.</li>
                @endforelse
            </ul>
        </div>

        {{-- ✅ أكثر المدن نشاطًا في مراكز الطوارئ --}}
        <div class="bg-white rounded shadow p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">🛠️ أكثر 3 مدن تحتوي مراكز طوارئ</h2>
            <ul class="list-disc list-inside text-gray-700">
                @forelse ($topEmergencyCities as $city)
                    <li>{{ $city->city }} - {{ $city->total }} مركز</li>
                @empty
                    <li>لا توجد بيانات حالياً.</li>
                @endforelse
            </ul>
        </div>

        {{-- ✅ قسم مستقبلي لمدن التاكسي --}}
        <div class="bg-white rounded shadow p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">🚖 أكثر المدن طلبًا لخدمة التاكسي</h2>
            <p class="text-gray-600">(يتم تنفيذ هذا القسم لاحقًا مع تحسين Delni Taxi 🚕)</p>
        </div>

    </div>
</x-app-layout>
