{{-- resources/views/layouts/partials/header.blade.php --}}

<div class="flex items-center justify-between px-6 py-4 bg-white shadow">

    {{-- ✅ الشعار --}}
    <div class="flex items-center space-x-3 rtl:space-x-reverse">
        <img
            src="{{ asset('images/delnilogo.png') }}"
            alt="Delni Logo"
            class="{{ request()->routeIs('about') ? 'h-4' : 'h-9' }}"
        >
        <span class="text-xl font-bold text-gray-800">Delni.co</span>
    </div>

    {{-- ✅ روابط التصفح --}}
    <nav class="space-x-6 rtl:space-x-reverse text-sm font-semibold">
        <a href="{{ route('home') }}" class="text-gray-700 hover:text-yellow-600">{{ __('messages.home') }}</a>
        <a href="{{ route('ads.index') }}" class="text-gray-700 hover:text-yellow-600">{{ __('messages.ads') }}</a>
        <a href="{{ route('about') }}" class="text-gray-700 hover:text-yellow-600">{{ __('messages.about') }}</a>
        <a href="{{ route('contact') }}" class="text-gray-700 hover:text-yellow-600">{{ __('messages.contact') }}</a>
        <a href="{{ route('drivers.map') }}" class="text-gray-700 hover:text-yellow-600">{{ __('messages.drivers_map') }}</a>

        {{-- ✅ زر Delni Taxi الجديد --}}
        <a href="{{ route('delni.taxi') }}"
           class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-full shadow">
            🚖 Delni Taxi
        </a>
    </nav>

    {{-- ✅ حساب المستخدم --}}
    @auth
        <div>
            <a href="{{ route('dashboard.index') }}" class="bg-yellow-500 text-white px-4 py-2 rounded shadow">
                {{ __('messages.my_account') }}
            </a>
        </div>
    @endauth

</div>
