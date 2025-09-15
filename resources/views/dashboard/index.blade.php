{{-- resources/views/dashboard/index.blade.php --}}
<x-app-layout>
<div class="max-w-7xl mx-auto px-4 py-10">

    {{-- 🟡 العنوان + زر Dark Mode --}}
    <div class="flex items-center justify-between mb-10">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">
            <i class="fas fa-tachometer-alt text-yellow-500"></i> {{ __('messages.dashboard') }}
        </h1>
    </div>

    {{-- 📊 الإحصائيات السريعة --}}
    <h2 class="text-xl font-bold mb-4 text-gray-700 dark:text-gray-200">📊 {{ __('messages.quick_stats') }}</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-6 mb-10">

        {{-- 📋 عدد إعلاناتي --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 text-center hover:shadow-lg transition">
            <i class="fas fa-bullhorn text-yellow-500 text-3xl mb-3"></i>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $myAdsCount ?? 0 }}</h2>
            <p class="text-gray-500 dark:text-gray-400">{{ __('messages.my_ads') }}</p>
        </div>

        {{-- ⭐ المميزة --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 text-center hover:shadow-lg transition">
            <i class="fas fa-star text-yellow-400 text-3xl mb-3"></i>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $featuredAdsCount ?? 0 }}</h2>
            <p class="text-gray-500 dark:text-gray-400">{{ __('messages.featured') }}</p>
        </div>

        {{-- ⚪ العادية --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 text-center hover:shadow-lg transition">
            <i class="fas fa-circle text-gray-500 text-3xl mb-3"></i>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $normalAdsCount ?? 0 }}</h2>
            <p class="text-gray-500 dark:text-gray-400">{{ __('messages.normal') }}</p>
        </div>

        {{-- ❤️ المفضلة --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 text-center hover:shadow-lg transition">
            <i class="fas fa-heart text-pink-500 text-3xl mb-3"></i>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $favoritesCount ?? 0 }}</h2>
            <p class="text-gray-500 dark:text-gray-400">{{ __('messages.favorites') }}</p>
        </div>

        {{-- 🚖 طلبات التاكسي --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 text-center hover:shadow-lg transition">
            <i class="fas fa-taxi text-green-500 text-3xl mb-3"></i>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $ordersCount ?? 0 }}</h2>
            <p class="text-gray-500 dark:text-gray-400">{{ __('messages.my_orders') }}</p>
        </div>

        {{-- 🚨 بلاغات الطوارئ --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 text-center hover:shadow-lg transition">
            <i class="fas fa-ambulance text-red-500 text-3xl mb-3"></i>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $emergencyReportsCount ?? 0 }}</h2>
            <p class="text-gray-500 dark:text-gray-400">{{ __('messages.delni_emergency') }}</p>
        </div>
    </div>

    {{-- 🟡 الكروت الرئيسية --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

        {{-- 📋 إعلاناتي --}}
        <a href="{{ route('dashboard.myads') }}" 
           class="bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-2xl shadow-lg p-6 text-white hover:scale-105 hover:shadow-xl transition transform">
            <i class="fas fa-bullhorn text-3xl mb-4"></i>
            <h2 class="text-xl font-bold">{{ __('messages.my_ads') }}</h2>
            <p class="text-sm opacity-90 mt-1">{{ __('messages.manage_my_ads') }}</p>
        </a>

        {{-- ➕ أضف إعلان جديد --}}
        <a href="{{ route('ads.create') }}" 
           class="bg-gradient-to-r from-green-400 to-green-500 rounded-2xl shadow-lg p-6 text-white hover:scale-105 hover:shadow-xl transition transform">
            <i class="fas fa-plus-circle text-3xl mb-4"></i>
            <h2 class="text-xl font-bold">{{ __('messages.add_ad') }}</h2>
            <p class="text-sm opacity-90 mt-1">✏️ {{ __('messages.add_new_ad') }}</p>
        </a>

        {{-- ❤️ المفضلة --}}
        <a href="{{ route('dashboard.favorites') }}" 
           class="bg-gradient-to-r from-pink-400 to-pink-500 rounded-2xl shadow-lg p-6 text-white hover:scale-105 hover:shadow-xl transition transform">
            <i class="fas fa-heart text-3xl mb-4"></i>
            <h2 class="text-xl font-bold">{{ __('messages.favorites') }}</h2>
            <p class="text-sm opacity-90 mt-1">❤️ {{ __('messages.favorite_ads') }}</p>
        </a>

        {{-- 🚖 طلبات Delni Taxi --}}
        <a href="{{ route('dashboard.myorders') }}" 
           class="bg-gradient-to-r from-green-400 to-green-500 rounded-2xl shadow-lg p-6 text-white hover:scale-105 hover:shadow-xl transition transform">
            <i class="fas fa-taxi text-3xl mb-4"></i>
            <h2 class="text-xl font-bold">{{ __('messages.my_orders') }}</h2>
            <p class="text-sm opacity-90 mt-1">🚖 {{ __('messages.track_orders') }}</p>
        </a>

        {{-- 🚨 الطوارئ --}}
          <a href="{{ route('emergency_services.index') }}"
           class="bg-gradient-to-r from-red-400 to-red-500 rounded-2xl shadow-lg p-6 text-white hover:scale-105 hover:shadow-xl transition transform">
            <i class="fas fa-ambulance text-3xl mb-4"></i>
            <h2 class="text-xl font-bold">{{ __('messages.delni_emergency') }}</h2>
            <p class="text-sm opacity-90 mt-1">🚨 {{ __('messages.emergency_centers') }}</p>
        </a>

        {{-- 👤 بياناتي --}}
        <a href="{{ route('dashboard.myinfo') }}" 
           class="bg-gradient-to-r from-blue-400 to-blue-500 rounded-2xl shadow-lg p-6 text-white hover:scale-105 hover:shadow-xl transition transform">
            <i class="fas fa-user-circle text-3xl mb-4"></i>
            <h2 class="text-xl font-bold">{{ __('messages.my_info') }}</h2>
            <p class="text-sm opacity-90 mt-1">👤 {{ __('messages.account_info') }}</p>
        </a>

        {{-- 🔑 تغيير كلمة المرور --}}
        <a href="{{ route('dashboard.password.change') }}" 
           class="bg-gradient-to-r from-purple-400 to-purple-500 rounded-2xl shadow-lg p-6 text-white hover:scale-105 hover:shadow-xl transition transform">
            <i class="fas fa-key text-3xl mb-4"></i>
            <h2 class="text-xl font-bold">{{ __('messages.change_password') }}</h2>
            <p class="text-sm opacity-90 mt-1">🔑 {{ __('messages.update_password') }}</p>
        </a>

        {{-- 🛠️ إدارة البلاغات (للمشرف فقط) --}}
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.emergency_reports.index') }}" 
           class="bg-gradient-to-r from-gray-600 to-gray-700 rounded-2xl shadow-lg p-6 text-white hover:scale-105 hover:shadow-xl transition transform">
            <i class="fas fa-exclamation-triangle text-3xl mb-4"></i>
            <h2 class="text-xl font-bold">إدارة البلاغات</h2>
            <p class="text-sm opacity-90 mt-1">🛠️ لوحة المشرف</p>
        </a>
        @endif
    </div>
</div>

{{-- ✅ FontAwesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

</x-app-layout>
