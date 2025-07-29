{{-- resources/views/admin/dashboard.blade.php --}}
<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold text-yellow-600 mb-8 text-center">🛡️ لوحة تحكم المشرف</h1>

        {{-- الروابط الثلاثة --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
<a href="{{ route('admin.reports.index') }}" class="bg-white shadow hover:shadow-lg p-6 rounded-xl text-center relative">
    <div class="text-4xl mb-2">🚨</div>
    <div class="text-lg font-bold text-gray-800">بلاغات الطوارئ</div>

    @if($newReportsCount > 0)
        <div class="absolute top-2 right-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full">
            {{ $newReportsCount }} جديد
        </div>
    @endif
</a>

            <a href="{{ route('dashboard.statistics') }}" class="bg-white shadow hover:shadow-lg p-6 rounded-xl text-center">
                <div class="text-4xl mb-2">📊</div>
                <div class="text-lg font-bold text-gray-800">إحصائيات الموقع</div>
            </a>

            <a href="{{ route('users.index') }}" class="bg-white shadow hover:shadow-lg p-6 rounded-xl text-center">
                <div class="text-4xl mb-2">👥</div>
                <div class="text-lg font-bold text-gray-800">إدارة المستخدمين</div>
            </a>
        </div>

        {{-- الإحصائيات الحية --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
            <div class="bg-white rounded shadow p-6">
                <p class="text-gray-500">عدد الإعلانات</p>
                <h2 class="text-2xl font-bold text-gray-800">{{ $adsCount }}</h2>
            </div>
            <div class="bg-white rounded shadow p-6">
                <p class="text-gray-500">عدد المستخدمين</p>
                <h2 class="text-2xl font-bold text-gray-800">{{ $usersCount }}</h2>
            </div>
            <div class="bg-white rounded shadow p-6">
                <p class="text-gray-500">عدد البلاغات الطارئة</p>
                <h2 class="text-2xl font-bold text-gray-800">{{ $reportsCount }}</h2>
            </div>
        </div>
    </div>
</x-app-layout>
