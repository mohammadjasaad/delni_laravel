<x-app-layout :title="__('messages.statistics')">
    <div class="max-w-7xl mx-auto px-4 py-10">

        {{-- 🟡 العنوان الرئيسي --}}
        <h1 class="text-3xl font-extrabold text-yellow-600 text-center mb-12">
            📊 إحصائيات الموقع
        </h1>

        {{-- 🔢 الكروت الرئيسية --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-12">
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-6 text-center">
                <div class="text-4xl font-extrabold text-yellow-600">{{ $userCount }}</div>
                <div class="text-gray-700 mt-3">👤 عدد المستخدمين</div>
            </div>
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-6 text-center">
                <div class="text-4xl font-extrabold text-yellow-600">{{ $adCount }}</div>
                <div class="text-gray-700 mt-3">📢 عدد الإعلانات</div>
            </div>
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-6 text-center">
                <div class="text-4xl font-extrabold text-yellow-600">{{ $emergencyCount }}</div>
                <div class="text-gray-700 mt-3">🆘 مراكز الطوارئ</div>
            </div>
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-6 text-center">
                <div class="text-4xl font-extrabold text-yellow-600">{{ $reportCount }}</div>
                <div class="text-gray-700 mt-3">🚨 عدد البلاغات</div>
            </div>
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-6 text-center">
                <div class="text-4xl font-extrabold text-yellow-600">{{ $driverCount }}</div>
                <div class="text-gray-700 mt-3">🚖 عدد السائقين</div>
            </div>
        </div>

        {{-- 🏙️ أكثر المدن نشاطًا في الإعلانات --}}
        <div class="bg-white rounded-xl shadow p-6 mb-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3">🏠 أكثر 3 مدن تحتوي إعلانات</h2>
            <ul class="divide-y divide-gray-200">
                @forelse ($topAdCities as $city)
                    <li class="flex justify-between items-center py-2">
                        <span class="font-medium">{{ $city->city }}</span>
                        <span class="text-gray-600">{{ $city->total }} إعلان</span>
                    </li>
                @empty
                    <li class="py-2 text-gray-500">لا توجد بيانات حالياً.</li>
                @endforelse
            </ul>
        </div>

        {{-- 🛠️ أكثر المدن نشاطًا في مراكز الطوارئ --}}
        <div class="bg-white rounded-xl shadow p-6 mb-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3">🚑 أكثر 3 مدن تحتوي مراكز طوارئ</h2>
            <ul class="divide-y divide-gray-200">
                @forelse ($topEmergencyCities as $city)
                    <li class="flex justify-between items-center py-2">
                        <span class="font-medium">{{ $city->city }}</span>
                        <span class="text-gray-600">{{ $city->total }} مركز</span>
                    </li>
                @empty
                    <li class="py-2 text-gray-500">لا توجد بيانات حالياً.</li>
                @endforelse
            </ul>
        </div>

        {{-- 🚕 قسم مستقبلي لإحصائيات التاكسي --}}
        <div class="bg-gradient-to-r from-yellow-50 to-white rounded-xl shadow p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">🚖 أكثر المدن طلبًا لخدمة Delni Taxi</h2>
            <p class="text-gray-600">
                (🔜 سيتم تنفيذ هذا القسم قريباً مع تطوير خدمة التاكسي 🚕 ليعرض أكثر المدن طلباً بشكل تفاعلي)
            </p>
        </div>

    </div>
</x-app-layout>
