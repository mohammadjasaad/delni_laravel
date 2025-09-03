{{-- resources/views/components/navbar.blade.php --}}
<nav class="bg-white border-b shadow-sm" x-data="{ open: false, adminMenu: false }">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">

        <!-- 🌐 اللغة -->
        <div class="text-sm">
            🌐
            @if(app()->getLocale() === 'ar')
                <a href="{{ route('change.lang', 'en') }}" class="text-gray-600 hover:text-yellow-600">English</a>
            @else
                <a href="{{ route('change.lang', 'ar') }}" class="text-gray-600 hover:text-yellow-600">العربية</a>
            @endif
        </div>

        <!-- 🖼️ الشعار -->
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <img src="{{ asset('images/delnilogo.png') }}" alt="Delni Logo" class="h-9">
            <span class="text-xl font-bold text-gray-800">Delni.co</span>
        </a>

        <!-- ✅ روابط سطح المكتب -->
        <nav class="hidden md:flex items-center gap-6 text-sm font-semibold">
            <a href="{{ route('home') }}" class="text-gray-700 hover:text-yellow-600">{{ __('messages.home') }}</a>
            <a href="{{ route('ads.index') }}" class="text-gray-700 hover:text-yellow-600">{{ __('messages.ads') }}</a>
            <a href="{{ route('about') }}" class="text-gray-700 hover:text-yellow-600">{{ __('messages.about') }}</a>
            <a href="{{ route('contact') }}" class="text-gray-700 hover:text-yellow-600">{{ __('messages.contact') }}</a>

            @auth
                {{-- 🛡️ روابط المشرف --}}
                @if(auth()->user()->role === 'admin')
                    <div class="relative" x-data="{ adminMenu: false }">
                        <button @click="adminMenu = !adminMenu"
                                class="text-blue-600 hover:text-blue-700 flex items-center gap-1 relative">
                            🛡️ لوحة المشرف ▾
                        </button>
                        <div x-show="adminMenu" @click.away="adminMenu = false"
                             class="absolute right-0 mt-2 w-72 bg-white border rounded shadow-md py-2 z-50">

                            <a href="{{ route('admin.dashboard') }}" class="flex justify-between items-center px-4 py-2 hover:bg-gray-100">
                                🏠 الرئيسية
                                <span class="text-xs bg-gray-200 text-gray-700 px-2 rounded">👥 {{ $visitorsCount ?? 0 }} زائر</span>
                            </a>
                            <hr class="my-1 border-gray-200">

                            <a href="{{ route('admin.statistics') }}" class="block px-4 py-2 hover:bg-gray-100">📊 إحصائيات عامة</a>
                            <a href="{{ route('admin.emergency.stats') }}" class="block px-4 py-2 hover:bg-gray-100">🚑 إحصائيات الطوارئ</a>
                            <a href="{{ route('admin.visitors.index') }}" class="block px-4 py-2 hover:bg-gray-100">👥 سجل الزوار</a>
                            <hr class="my-1 border-gray-200">

                            <a href="{{ route('admin.emergency_reports.index') }}" class="flex justify-between items-center px-4 py-2 hover:bg-gray-100">
                                🚨 بلاغات الطوارئ
                                @if(!empty($newReportsCount) && $newReportsCount > 0)
                                    <span class="bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $newReportsCount }}</span>
                                @endif
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 hover:bg-gray-100">👥 إدارة المستخدمين</a>
                            <a href="{{ route('admin.notifications') }}" class="flex justify-between items-center px-4 py-2 hover:bg-gray-100">
                                🔔 إشعارات
                                @if(!empty($newNotificationsCount) && $newNotificationsCount > 0)
                                    <span class="bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $newNotificationsCount }}</span>
                                @endif
                            </a>
                        </div>
                    </div>
                @endif
            @endauth
        </nav>

        <!-- ✅ الحساب أو الدخول (سطح المكتب) -->
        <div class="hidden md:block">
            @auth
                <a href="{{ route('dashboard.index') }}"
                   class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">
                    {{ __('messages.dashboard') }}
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="text-sm text-yellow-600 hover:underline">
                    {{ __('messages.login') }}
                </a>
            @endauth
        </div>

        <!-- ✅ زر الموبايل -->
        <div class="md:hidden flex items-center">
            <button @click="open = !open"
                    class="text-gray-700 focus:outline-none hover:text-yellow-600">
                <span x-show="!open">☰</span>
                <span x-show="open">✖</span>
            </button>
        </div>
    </div>

    <!-- ✅ قائمة الموبايل -->
    <div x-show="open" x-transition class="md:hidden bg-white border-t shadow-sm">
        <nav class="px-4 py-3 space-y-2 text-sm">
            <a href="{{ route('home') }}" class="block text-gray-700 hover:text-yellow-600">{{ __('messages.home') }}</a>
            <a href="{{ route('ads.index') }}" class="block text-gray-700 hover:text-yellow-600">{{ __('messages.ads') }}</a>
            <a href="{{ route('about') }}" class="block text-gray-700 hover:text-yellow-600">{{ __('messages.about') }}</a>
            <a href="{{ route('contact') }}" class="block text-gray-700 hover:text-yellow-600">{{ __('messages.contact') }}</a>

            @auth
                {{-- 🛡️ روابط المشرف للموبايل --}}
                @if(auth()->user()->role === 'admin')
                    <div x-data="{ adminMenu: false }">
                        <button @click="adminMenu = !adminMenu"
                                class="block w-full text-left text-blue-600 hover:text-blue-700">
                            🛡️ لوحة المشرف ▾
                        </button>
                        <div x-show="adminMenu" class="pl-4 mt-2 space-y-1">
                            <a href="{{ route('admin.dashboard') }}" class="flex justify-between items-center hover:bg-gray-100 px-2 py-1">
                                🏠 الرئيسية
                                <span class="text-xs bg-gray-200 text-gray-700 px-2 rounded">👥 {{ $visitorsCount ?? 0 }}</span>
                            </a>
                            <a href="{{ route('admin.statistics') }}" class="block hover:bg-gray-100 px-2 py-1">📊 إحصائيات عامة</a>
                            <a href="{{ route('admin.emergency.stats') }}" class="block hover:bg-gray-100 px-2 py-1">🚑 إحصائيات الطوارئ</a>
                            <a href="{{ route('admin.visitors.index') }}" class="block hover:bg-gray-100 px-2 py-1">👥 سجل الزوار</a>
                            <a href="{{ route('admin.emergency_reports.index') }}" class="flex justify-between items-center hover:bg-gray-100 px-2 py-1">
                                🚨 بلاغات الطوارئ
                                @if(!empty($newReportsCount) && $newReportsCount > 0)
                                    <span class="bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $newReportsCount }}</span>
                                @endif
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="block hover:bg-gray-100 px-2 py-1">👥 إدارة المستخدمين</a>
                            <a href="{{ route('admin.notifications') }}" class="flex justify-between items-center hover:bg-gray-100 px-2 py-1">
                                🔔 إشعارات
                                @if(!empty($newNotificationsCount) && $newNotificationsCount > 0)
                                    <span class="bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $newNotificationsCount }}</span>
                                @endif
                            </a>
                        </div>
                    </div>
                @endif

                <a href="{{ route('dashboard.index') }}"
                   class="block w-full text-center bg-yellow-500 text-white px-3 py-2 rounded hover:bg-yellow-600">
                    {{ __('messages.dashboard') }}
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="block w-full text-center bg-yellow-500 text-white px-3 py-2 rounded hover:bg-yellow-600">
                    {{ __('messages.login') }}
                </a>
            @endauth
        </nav>
    </div>
</nav>
