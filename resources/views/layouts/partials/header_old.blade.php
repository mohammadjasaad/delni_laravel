{{-- resources/views/layouts/partials/header.blade.php --}}
<header class="bg-white dark:bg-gray-900 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-3 grid grid-cols-3 items-center">

        {{-- ✅ أقصى اليمين: الشعار --}}
        <div class="flex justify-start items-center gap-2">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/delnilogo.png') }}" alt="Delni Logo" class="h-9">
                <span class="text-xl font-bold text-gray-800 dark:text-gray-100">Delni.co</span>
            </a>
        </div>

        {{-- ✅ الوسط: روابط رئيسية --}}
        <nav class="flex justify-center gap-6 text-sm font-medium text-gray-700 dark:text-gray-300">
            <a href="{{ route('home') }}" class="hover:text-yellow-500">{{ __('messages.home') }}</a>
            <a href="{{ route('ads.index') }}" class="hover:text-yellow-500">{{ __('messages.ads') }}</a>
            <a href="{{ route('about') }}" class="hover:text-yellow-500">{{ __('messages.about') }}</a>
            <a href="{{ route('contact') }}" class="hover:text-yellow-500">{{ __('messages.contact') }}</a>
        </nav>

        {{-- ✅ أقصى اليسار: الأزرار --}}
        <div class="flex justify-end items-center gap-3">
            {{-- زر الفلاتر (فقط في صفحة الإعلانات) --}}
            @if(request()->routeIs('ads.index'))
                <button id="toggle-filters"
                        class="px-3 py-1.5 rounded bg-gray-100 dark:bg-gray-800 
                               text-gray-700 dark:text-gray-300 hover:bg-gray-200 
                               dark:hover:bg-gray-700 text-sm">
                    ⚙️ {{ __('messages.filters') }}
                </button>
            @endif

            {{-- ➕ إضافة إعلان --}}
            <a href="{{ route('ads.create') }}"
               class="px-3 py-1.5 rounded bg-gray-100 dark:bg-gray-800 
                      text-gray-700 dark:text-gray-300 hover:bg-gray-200 
                      dark:hover:bg-gray-700 text-sm">
                ➕ {{ __('messages.add_ad') }}
            </a>

            {{-- 👤 الحساب --}}
            @auth
                <a href="{{ route('dashboard.index') }}"
                   class="px-3 py-1.5 rounded bg-gray-100 dark:bg-gray-800 
                          text-gray-700 dark:text-gray-300 hover:bg-gray-200 
                          dark:hover:bg-gray-700 text-sm">
                    👤 {{ __('messages.my_account') }}
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="px-3 py-1.5 rounded bg-gray-100 dark:bg-gray-800 
                          text-gray-700 dark:text-gray-300 hover:bg-gray-200 
                          dark:hover:bg-gray-700 text-sm">
                    👤 {{ __('messages.login') }}
                </a>
            @endauth

            {{-- 🌐 اللغة --}}
            <a href="{{ route('change.lang', app()->getLocale() === 'ar' ? 'en' : 'ar') }}"
               class="px-3 py-1.5 rounded bg-gray-100 dark:bg-gray-800 
                      text-gray-700 dark:text-gray-300 hover:bg-gray-200 
                      dark:hover:bg-gray-700 text-sm">
                🌐 {{ app()->getLocale() === 'ar' ? 'English' : 'العربية' }}
            </a>
        </div>
    </div>
</header>
