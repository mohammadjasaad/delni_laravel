<nav class="bg-white border-b border-gray-200 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center space-x-2 rtl:space-x-reverse">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="h-8 w-8">
            </div>

            <!-- ✅ القائمة الرئيسية (للحواسيب) -->
            <div class="hidden md:flex space-x-4 rtl:space-x-reverse items-center">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-yellow-600 font-semibold">🏠 الرئيسية</a>
                <a href="{{ route('ads.index') }}" class="text-gray-700 hover:text-yellow-600 font-semibold">📢 الإعلانات</a>
                <a href="{{ route('about') }}" class="text-gray-700 hover:text-yellow-600 font-semibold">📝 عن دلني</a>
                <a href="{{ route('services') }}" class="text-gray-700 hover:text-yellow-600 font-semibold">🛠️ الخدمات</a>

                {{-- ✅ دلني عاجل --}}
                <a href="{{ route('emergency_services.index') }}"
                   class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md font-bold shadow-md transition">
                    🆘 دلني عاجل
                </a>

                <a href="{{ route('contact') }}" class="text-gray-700 hover:text-yellow-600 font-semibold">📞 اتصل بنا</a>

                @auth
                    <a href="{{ route('dashboard.index') }}"
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md font-semibold shadow">
                        🙍‍♂️ حسابي
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                                class="text-gray-700 hover:text-red-600 font-semibold ml-2">
                            🔓 تسجيل الخروج
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md font-semibold shadow">
                        🔐 تسجيل الدخول
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
                        class="text-gray-600 focus:outline-none focus:text-yellow-600">
                    ☰
                </button>
            </div>
        </div>
    </div>

    {{-- ✅ قائمة الجوال المنسدلة --}}
    <div class="sm:hidden hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}"
               class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-200">
                🏠 الرئيسية
            </a>

            <a href="{{ route('ads.index') }}"
               class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-200">
                📢 الإعلانات
            </a>

            <a href="{{ route('emergency.index') }}"
               class="block w-full text-center text-white bg-pink-500 hover:bg-pink-600 px-3 py-2 rounded-md font-semibold">
                🆘 دلني عاجل
            </a>

            <a href="{{ route('services') }}"
               class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-200">
                🛠️ خدمات
            </a>

            @auth
                <a href="{{ route('dashboard.index') }}"
                   class="block w-full text-center bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-md font-semibold">
                    🙍‍♂️ حسابي
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="block w-full text-center bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-md font-semibold">
                    🔐 تسجيل الدخول
                </a>
            @endauth
        </div>
    </div>
</nav>
