<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-4">

        <h1 class="text-2xl font-bold text-yellow-600 mb-6">📊 إحصائياتي</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded shadow p-6 text-center">
                <div class="text-4xl font-bold text-yellow-600">{{ $myAdsCount }}</div>
                <div class="text-gray-700 mt-2">📢 إعلاناتي</div>
            </div>

            <div class="bg-white rounded shadow p-6 text-center">
                <div class="text-4xl font-bold text-yellow-600">{{ $favoritesCount }}</div>
                <div class="text-gray-700 mt-2">❤️ المفضلة</div>
            </div>

            <div class="bg-white rounded shadow p-6 text-center">
                <div class="text-4xl font-bold text-yellow-600">{{ $myReportsCount }}</div>
                <div class="text-gray-700 mt-2">🚨 بلاغاتي</div>
            </div>

            <div class="bg-white rounded shadow p-6 text-center">
                <div class="text-4xl font-bold text-yellow-600">{{ $myOrdersCount }}</div>
                <div class="text-gray-700 mt-2">🚖 طلباتي</div>
            </div>
        </div>

    </div>
</x-app-layout>
