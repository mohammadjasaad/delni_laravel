{{-- resources/views/components/header.blade.php --}}
<header class="bg-white dark:bg-gray-900 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">

        {{-- ✅ أقصى اليمين: الشعار --}}
        <div class="flex items-center gap-2">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/delnilogo.png') }}" alt="Delni Logo" class="h-9">
                <span class="text-xl font-bold text-gray-800 dark:text-gray-100">Delni.co</span>
            </a>
        </div>

        {{-- ✅ الوسط: روابط رئيسية --}}
        <nav class="flex gap-6 text-sm font-medium text-gray-700 dark:text-gray-300">
            <a href="{{ route('home') }}" class="hover:text-yellow-500">{{ __('messages.home') }}</a>
            <a href="{{ route('about') }}" class="hover:text-yellow-500">{{ __('messages.about') }}</a>
            <a href="{{ route('contact') }}" class="hover:text-yellow-500">{{ __('messages.contact') }}</a>

            {{-- 🔹 زر إضافي للمشرف فقط --}}
            @if(auth()->check() && auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="hover:text-red-500 font-semibold">
                    🛠️ {{ __('messages.admin_dashboard') }}
                </a>
            @endif
        </nav>

        {{-- ✅ أقصى اليسار: الأزرار --}}
        <div class="flex items-center gap-3">
            {{-- زر إضافة إعلان --}}
            <a href="{{ route('ads.create') }}"
               class="px-3 py-1.5 rounded bg-gray-100 dark:bg-gray-800 text-gray-700 
                      dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 text-sm">
                ➕ {{ __('messages.add_ad') }}
            </a>

            {{-- دخول/لوحة التحكم/خروج --}}
            @auth
                <a href="{{ route('dashboard.index') }}"
                   class="px-3 py-1.5 rounded bg-gray-100 dark:bg-gray-800 text-gray-700 
                          dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 text-sm">
                    👤 {{ __('messages.dashboard') }}
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                            class="px-3 py-1.5 rounded bg-gray-100 dark:bg-gray-800 text-gray-700 
                                   dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 text-sm">
                        🚪 {{ __('messages.logout') }}
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                   class="px-3 py-1.5 rounded bg-gray-100 dark:bg-gray-800 text-gray-700 
                          dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 text-sm">
                    👤 {{ __('messages.login') }}
                </a>
            @endauth

            {{-- زر اللغة --}}
            <a href="{{ route('change.lang', app()->getLocale() === 'ar' ? 'en' : 'ar') }}"
               class="px-3 py-1.5 rounded bg-gray-100 dark:bg-gray-800 text-gray-700 
                      dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 text-sm">
                🌐 {{ app()->getLocale() === 'ar' ? 'English' : 'العربية' }}
            </a>
        </div>
    </div>
</header>
