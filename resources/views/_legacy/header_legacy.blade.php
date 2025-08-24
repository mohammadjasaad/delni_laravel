{{-- resources/views/layouts/partials/header.blade.php --}}

<div class="flex items-center justify-between flex-wrap gap-4 px-6 py-4 bg-white shadow">

    {{-- ✅ الشعار --}}
    <div class="flex items-center gap-3">
        <img
            src="{{ asset('images/delnilogo.png') }}"
            alt="Delni Logo"
            class="{{ request()->routeIs('about') ? 'h-4' : 'h-9' }}"
        >
        <span class="text-xl font-bold text-gray-800">Delni.co</span>
    </div>

{{-- ✅ روابط التصفح (مخفية على الموبايل) --}}
<nav class="hidden lg:flex flex-wrap gap-4 text-sm font-semibold text-gray-700">
    <a href="{{ route('home') }}" class="hover:text-yellow-600">{{ __('messages.home') }}</a>
    <a href="{{ route('ads.index') }}" class="hover:text-yellow-600">{{ __('messages.ads') }}</a>
    <a href="{{ route('about') }}" class="hover:text-yellow-600">{{ __('messages.about') }}</a>
    <a href="{{ route('contact') }}" class="hover:text-yellow-600">{{ __('messages.contact') }}</a>
</nav>

    {{-- ✅ حساب المستخدم + اللغة + أضف إعلان --}}
    <div class="flex items-center gap-4 text-sm">

        {{-- 🌐 زر تغيير اللغة --}}
        <div>
            <a href="{{ route('lang.switch', 'ar') }}" class="{{ app()->getLocale() == 'ar' ? 'font-bold underline text-yellow-600' : 'text-gray-600' }}">العربية</a>
            |
            <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'font-bold underline text-yellow-600' : 'text-gray-600' }}">English</a>
        </div>

        {{-- ➕ زر أضف إعلان --}}
        @auth
            <a href="{{ route('dashboard.ads.create') }}" class="bg-yellow-400 hover:bg-yellow-500 text-black font-bold px-4 py-2 rounded-full shadow">
                ➕ {{ __('messages.add_ad') }}
            </a>
        @endauth

        {{-- 👤 حسابي / تسجيل الدخول --}}
        @auth
            <a href="{{ route('dashboard.index') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow">
                {{ __('messages.my_account') }}
            </a>
        @else
            <a href="{{ route('login') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded shadow">
                {{ __('messages.login') }}
            </a>
        @endauth

    </div>
</div>
