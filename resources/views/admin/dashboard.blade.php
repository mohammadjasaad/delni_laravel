{{-- resources/views/admin/dashboard.blade.php --}}
<x-app-layout :isAdmin="true">
    <div class="max-w-7xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold text-yellow-600 mb-10 text-center">
            🛡️ {{ __('messages.admin_dashboard') }}
        </h1>

        {{-- 🔗 روابط رئيسية --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-12">

            {{-- 🚨 البلاغات --}}
            <a href="{{ route('admin.emergency_reports.index') }}"
               class="bg-red-100 hover:bg-red-200 shadow p-6 rounded-xl text-center relative transition">
                <div class="text-4xl mb-2">🚨</div>
                <div class="text-lg font-bold text-gray-800">{{ __('messages.emergency_reports') }}</div>
                @if(!empty($newReportsCount) && $newReportsCount > 0)
                    <div class="absolute top-2 right-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                        {{ $newReportsCount }} {{ __('messages.new') }}
                    </div>
                @endif
            </a>

            {{-- 📊 الإحصائيات --}}
            <a href="{{ route('admin.statistics') }}"
               class="bg-blue-100 hover:bg-blue-200 shadow p-6 rounded-xl text-center transition">
                <div class="text-4xl mb-2">📊</div>
                <div class="text-lg font-bold text-gray-800">{{ __('messages.statistics') }}</div>
            </a>

            {{-- 👥 إدارة المستخدمين --}}
            <a href="{{ route('admin.users.index') }}"
               class="bg-green-100 hover:bg-green-200 shadow p-6 rounded-xl text-center transition">
                <div class="text-4xl mb-2">👥</div>
                <div class="text-lg font-bold text-gray-800">{{ __('messages.manage_users') }}</div>
            </a>

            {{-- 🔔 الإشعارات --}}
            <a href="{{ route('admin.notifications') }}"
               class="bg-yellow-100 hover:bg-yellow-200 shadow p-6 rounded-xl text-center transition">
                <div class="text-4xl mb-2">🔔</div>
                <div class="text-lg font-bold text-gray-800">{{ __('messages.notifications') }}</div>
            </a>

            {{-- 🛠️ تذاكر الدعم الفني --}}
            <a href="{{ route('admin.support_tickets.index') }}"
               class="bg-purple-100 hover:bg-purple-200 shadow p-6 rounded-xl text-center transition">
                <div class="text-4xl mb-2">🛠️</div>
                <div class="text-lg font-bold text-gray-800">{{ __('messages.support_tickets') }}</div>
            </a>
        </div>

        {{-- 📈 إحصائيات حية --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 text-center">
            <div class="bg-white rounded-xl shadow p-6">
                <p class="text-gray-500">{{ __('messages.ads_count') }}</p>
                <h2 class="text-2xl font-bold text-gray-800">{{ $adCount }}</h2>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <p class="text-gray-500">{{ __('messages.users_count') }}</p>
                <h2 class="text-2xl font-bold text-gray-800">{{ $userCount }}</h2>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <p class="text-gray-500">{{ __('messages.emergency_reports_count') }}</p>
                <h2 class="text-2xl font-bold text-gray-800">{{ $reportCount }}</h2>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <p class="text-gray-500">{{ __('messages.visitors_count') }}</p>
                <h2 class="text-2xl font-bold text-gray-800">{{ $visitorsCount }}</h2>
            </div>
        </div>
    </div>
</x-app-layout>

