<header class="bg-white dark:bg-gray-900 shadow-sm relative z-[2000] !py-0">
    <div class="max-w-7xl mx-auto px-4 py-1 flex items-center justify-between">

        {{-- ✅ أقصى اليمين: الشعار --}}
        <div class="flex items-center gap-2">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/delnilogo.png') }}" alt="Delni Logo" class="h-9">
                <span class="text-xl font-bold text-gray-800 dark:text-gray-100">Delni.co</span>
            </a>
        </div>

        {{-- ✅ الوسط: روابط رئيسية (ثابتة للجميع) --}}
        <nav class="hidden md:flex gap-6 text-sm font-medium text-gray-700 dark:text-gray-300">
        </nav>

        {{-- ✅ أقصى اليسار: أزرار التحكم (للكمبيوتر) --}}
        <div class="hidden md:flex items-center gap-3">
            {{-- زر إضافة إعلان --}}
            @if(auth()->check() && auth()->user()->role !== 'admin')
                <a href="{{ route('ads.create') }}"
                   class="px-3 py-1.5 rounded bg-gray-100 dark:bg-gray-800 
                          text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 text-sm">
                    ➕ {{ __('messages.add_ad') }}
                </a>
            @endif

            {{-- 🏬 زر متجري --}}
            @auth
                @php
                    $userStore = \App\Models\Store::where('user_id', auth()->id())->first();
                @endphp
                @if($userStore)
                    <a href="{{ route('mall.dashboard', $userStore->id) }}"
                       class="px-3 py-1.5 rounded bg-yellow-400 text-black font-semibold shadow hover:bg-yellow-500 transition text-sm flex items-center gap-1">
                        <i class="fas fa-store"></i> {{ __('mall.my_store') }}
                    </a>
                @endif
            @endauth

            {{-- دخول/لوحة التحكم --}}
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                       class="px-3 py-1.5 rounded bg-yellow-500 text-white hover:bg-yellow-600 text-sm">
                        🛠️ {{ __('messages.admin_panel') }}
                    </a>
                @else
                    <a href="{{ route('dashboard.index') }}"
                       class="px-3 py-1.5 rounded bg-gray-100 dark:bg-gray-800 
                              text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 text-sm">
                        👤 {{ __('messages.dashboard') }}
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                            class="px-3 py-1.5 rounded bg-red-500 text-white hover:bg-red-600 text-sm">
                        🚪 {{ __('messages.logout') }}
                    </button>
                </form>
            @else
<a href="{{ route('login') }}"
   class="px-3 py-1.5 rounded bg-gray-100 dark:bg-gray-800 
          text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 text-sm">
    👤 {{ __('messages.login') }}
</a>
            @endauth

            {{-- زر اللغة --}}
            <a href="{{ route('change.lang', app()->getLocale() === 'ar' ? 'en' : 'ar') }}"
               class="px-3 py-1.5 rounded bg-gray-100 dark:bg-gray-800 
                      text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 text-sm">
                🌐 {{ app()->getLocale() === 'ar' ? __('messages.lang_en') : __('messages.lang_ar') }}
            </a>

            {{-- 🌙 زر Dark/Light Mode للكمبيوتر --}}
            <button id="toggleDarkModeDesktop"
                    class="px-3 py-1.5 rounded bg-gray-200 dark:bg-gray-700 
                           text-gray-800 dark:text-gray-200 hover:scale-105 transition text-sm">
                🌙
            </button>
        </div>

        {{-- ✅ أزرار الموبايل: دارك مود + منيو --}}
        <div class="md:hidden flex items-center gap-2">
            {{-- 🌙 زر Dark/Light Mode للموبايل --}}
            <button id="toggleDarkModeMobile"
                    class="p-2 rounded bg-gray-200 dark:bg-gray-700 
                           text-gray-800 dark:text-gray-200 hover:scale-105 transition">
                🌙
            </button>

            {{-- زر القائمة ☰ --}}
            <button id="mobileMenuBtn"
                    class="p-2 rounded bg-gray-100 dark:bg-gray-800">
                ☰
            </button>
        </div>
    </div>

    {{-- ✅ القائمة الجانبية للموبايل (تنزل لتحت) --}}
    <div id="mobileMenu"
         class="hidden md:hidden absolute top-full left-0 w-full bg-white dark:bg-gray-900 border-t p-4 space-y-3 shadow-lg z-50">
        <a href="{{ route('home') }}" class="block hover:text-yellow-500">{{ __('messages.home') }}</a>

        @if(auth()->check() && auth()->user()->role !== 'admin')
            <a href="{{ route('ads.create') }}" class="block hover:text-yellow-500">➕ {{ __('messages.add_ad') }}</a>
        @endif

        {{-- 🏬 زر متجري (موبايل) --}}
        @auth
            @php
                $userStore = \App\Models\Store::where('user_id', auth()->id())->first();
            @endphp
            @if($userStore)
                <a href="{{ route('mall.dashboard', $userStore->id) }}" class="block hover:text-yellow-500">
                    <i class="fas fa-store"></i> {{ __('mall.my_store') }}
                </a>
            @endif
        @endauth

        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="block hover:text-yellow-500">🛠️ {{ __('messages.admin_panel') }}</a>
            @else
                <a href="{{ route('dashboard.index') }}" class="block hover:text-yellow-500">👤 {{ __('messages.dashboard') }}</a>
            @endif

            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                @csrf
                <button type="submit" class="w-full text-left text-red-600 hover:text-red-700">
                    🚪 {{ __('messages.logout') }}
                </button>
            </form>
        @else
<a href="{{ route('login') }}" class="block hover:text-yellow-500">
    👤 {{ __('messages.login') }}
</a>

        <a href="{{ route('change.lang', app()->getLocale() === 'ar' ? 'en' : 'ar') }}"
           class="block hover:text-yellow-500">
            🌐 {{ app()->getLocale() === 'ar' ? 'English' : 'العربية' }}
        </a>
    </div>
@endif

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const btn = document.getElementById("mobileMenuBtn");
            const menu = document.getElementById("mobileMenu");
            btn.addEventListener("click", () => {
                menu.classList.toggle("hidden");
            });
        });
    </script>
</header>
