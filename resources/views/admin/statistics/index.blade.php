{{-- resources/views/admin/statistics/index.blade.php --}}
<x-app-layout :isAdmin="true" title="إحصائيات الموقع">
    <div class="max-w-6xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">📊 إحصائيات الموقع</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded shadow text-center">
                <h2 class="text-lg font-semibold text-gray-700">👥 عدد المستخدمين</h2>
                <p class="text-3xl font-bold text-blue-600 mt-2">{{ $userCount }}</p>
            </div>

            <div class="bg-white p-6 rounded shadow text-center">
                <h2 class="text-lg font-semibold text-gray-700">📢 عدد الإعلانات</h2>
                <p class="text-3xl font-bold text-green-600 mt-2">{{ $adCount }}</p>
            </div>

            <div class="bg-white p-6 rounded shadow text-center">
                <h2 class="text-lg font-semibold text-gray-700">🚑 مراكز الطوارئ</h2>
                <p class="text-3xl font-bold text-red-600 mt-2">{{ $emergencyCount }}</p>
            </div>

            <div class="bg-white p-6 rounded shadow text-center">
                <h2 class="text-lg font-semibold text-gray-700">🚨 بلاغات الطوارئ</h2>
                <p class="text-3xl font-bold text-orange-600 mt-2">{{ $reportCount }}</p>
            </div>

            <div class="bg-white p-6 rounded shadow text-center">
                <h2 class="text-lg font-semibold text-gray-700">🚖 عدد السائقين</h2>
                <p class="text-3xl font-bold text-purple-600 mt-2">{{ $driverCount }}</p>
            </div>
        </div>

        <div class="mt-10">
            <h2 class="text-xl font-bold text-gray-800 mb-4">🏙️ أكثر المدن نشاطاً</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded shadow">
                    <h3 class="font-semibold text-gray-700 mb-3">📢 الإعلانات</h3>
                    <ul class="list-disc list-inside text-gray-600">
                        @forelse($topAdCities as $city)
                            <li>{{ $city->city }} - {{ $city->total }} إعلان</li>
                        @empty
                            <li>لا يوجد بيانات</li>
                        @endforelse
                    </ul>
                </div>
                <div class="bg-white p-6 rounded shadow">
                    <h3 class="font-semibold text-gray-700 mb-3">🚑 مراكز الطوارئ</h3>
                    <ul class="list-disc list-inside text-gray-600">
                        @forelse($topEmergencyCities as $city)
                            <li>{{ $city->city }} - {{ $city->total }} مركز</li>
                        @empty
                            <li>لا يوجد بيانات</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
