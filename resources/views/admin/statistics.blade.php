{{-- resources/views/admin/statistics.blade.php --}}
<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold text-yellow-600 mb-8 text-center">📊 إحصائيات الموقع التفصيلية</h1>

        {{-- الأقسام الرئيسية للإحصائيات --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center mb-10">
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-6">
                <p class="text-gray-500">عدد الإعلانات</p>
                <h2 class="text-3xl font-extrabold text-gray-800">{{ $adsCount }}</h2>
            </div>
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-6">
                <p class="text-gray-500">عدد الإعلانات المميزة</p>
                <h2 class="text-3xl font-extrabold text-yellow-500">{{ $featuredAdsCount }}</h2>
            </div>
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-6">
                <p class="text-gray-500">عدد المستخدمين</p>
                <h2 class="text-3xl font-extrabold text-green-600">{{ $usersCount }}</h2>
            </div>
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-6">
                <p class="text-gray-500">عدد مراكز الطوارئ</p>
                <h2 class="text-3xl font-extrabold text-red-600">{{ $emergencyCentersCount }}</h2>
            </div>
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-6">
                <p class="text-gray-500">عدد البلاغات الطارئة</p>
                <h2 class="text-3xl font-extrabold text-pink-600">{{ $reportsCount }}</h2>
            </div>
        </div>

        {{-- المدن الأكثر نشاطاً --}}
        <div class="bg-white rounded-xl shadow p-6 mb-10">
            <h2 class="text-xl font-bold text-center text-gray-800 mb-4">🏙️ المدن الأكثر نشاطًا</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-center border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-4 border-b">المدينة</th>
                            <th class="py-2 px-4 border-b">عدد الإعلانات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($topCities as $city)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $city->city }}</td>
                                <td class="py-2 px-4 border-b">{{ $city->total }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-4 text-gray-500">لا توجد بيانات حالياً.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- أقسام إحصائية إضافية مستقبلية --}}
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-6 rounded-xl text-center">
            <h3 class="font-bold mb-2">🚀 قريبًا</h3>
            <ul class="list-disc list-inside text-sm md:text-base space-y-1">
                <li>📈 رسوم بيانية تفصيلية</li>
                <li>📂 إحصائيات حسب التصنيف</li>
                <li>⏱️ متوسط زمن الاستجابة للبلاغات</li>
                <li>🧭 توزيع الإعلانات على الخريطة</li>
            </ul>
        </div>
    </div>
</x-app-layout>
