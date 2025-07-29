<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
        <div class="text-sm">
    🌐 
    @if(app()->getLocale() === 'ar')
        <a href="{{ route('change.lang', 'en') }}" class="text-gray-600 hover:text-yellow-600">English</a>
    @else
        <a href="{{ route('change.lang', 'ar') }}" class="text-gray-600 hover:text-yellow-600">العربية</a>
    @endif
</div>
        <!-- الشعار -->
        <a href="{{ route('home') }}" class="flex items-center space-x-2">
            <img src="{{ asset('images/delnilogo.png') }}" alt="Delni Logo" class="h-9">
            <span class="text-xl font-bold text-gray-800">Delni.co</span>
        </a>

<!-- روابط التنقل -->
<nav class="space-x-4 text-sm">
    <a href="{{ route('home') }}" class="text-gray-700 hover:text-yellow-500">{{ __('messages.home') }}</a>
    <a href="{{ route('ads.index') }}" class="text-gray-700 hover:text-yellow-500">{{ __('messages.ads') }}</a>
    <a href="{{ route('about') }}" class="text-gray-700 hover:text-yellow-500">{{ __('messages.about') }}</a>
    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-yellow-500">{{ __('messages.contact') }}</a>

    @auth
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.emergency_reports.index') }}" class="text-red-600 font-semibold hover:text-red-700">
                🚨 إدارة البلاغات
            </a>
        @endif
    @endauth
</nav>

        <!-- الحساب أو الدخول -->
        <div>
            @auth
                <a href="{{ route('dashboard.index') }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">
                    {{ __('messages.dashboard') }}
                </a>
            @else
                <a href="{{ route('login') }}" class="text-sm text-yellow-600 hover:underline">
                    {{ __('messages.login') }}
                </a>
            @endauth
        </div>

    </div>
</header>
