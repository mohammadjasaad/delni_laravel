<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center space-x-2">
            <img src="{{ asset('images/delni-logo.png') }}" alt="Delni Logo" class="h-10">
            <span class="font-bold text-xl text-gray-800">Delni.co</span>
        </a>

        <!-- Navigation -->
        <nav class="space-x-6">
            <a href="{{ route('ads.index') }}" class="text-gray-700 hover:text-yellow-500 font-medium">{{ __('messages.ads') }}</a>
            <a href="{{ route('about') }}" class="text-gray-700 hover:text-yellow-500 font-medium">{{ __('messages.about') }}</a>
            <a href="{{ route('contact') }}" class="text-gray-700 hover:text-yellow-500 font-medium">{{ __('messages.contact') }}</a>
            <a href="{{ route('dashboard.index') }}" class="text-gray-700 hover:text-yellow-500 font-medium">{{ __('messages.dashboard') }}</a>
        </nav>
    </div>
</header>
