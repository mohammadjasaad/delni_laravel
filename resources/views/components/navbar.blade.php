<nav class="bg-white border-b border-gray-200 shadow-md">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16 items-center">

      {{-- helpers للروابط المعرضة للكسر --}}
      @php
        $hasLang = \Illuminate\Support\Facades\Route::has('change.lang');
        $dashboardHref = \Illuminate\Support\Facades\Route::has('dashboard.index')
            ? route('dashboard.index')
            : (\Illuminate\Support\Facades\Route::has('dashboard')
                ? route('dashboard')
                : url('/dashboard'));
      @endphp

      <!-- Logo + Language -->
      <div class="flex items-center gap-4">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
          <img src="{{ asset('logo.png') }}" alt="Logo" class="h-8 w-8">
          <span class="text-xl font-bold text-gray-800">Delni.co</span>
        </a>

        <div class="hidden sm:block text-sm">
          🌐
          @if(app()->getLocale()==='ar')
            <a href="{{ $hasLang ? route('change.lang','en') : url('/lang/en') }}"
               class="text-gray-600 hover:text-yellow-600">English</a>
          @else
            <a href="{{ $hasLang ? route('change.lang','ar') : url('/lang/ar') }}"
               class="text-gray-600 hover:text-yellow-600">العربية</a>
          @endif
        </div>
      </div>

      <!-- Desktop Menu -->
      <div class="hidden md:flex items-center gap-4">
        <a href="{{ route('home') }}" class="text-gray-700 hover:text-yellow-600 font-semibold">🏠 الرئيسية</a>
        <a href="{{ route('ads.index') }}" class="text-gray-700 hover:text-yellow-600 font-semibold">📢 الإعلانات</a>
        <a href="{{ route('about') }}" class="text-gray-700 hover:text-yellow-600 font-semibold">📝 عن دلني</a>

        <a href="{{ \Illuminate\Support\Facades\Route::has('services') ? route('services') : url('/services') }}"
           class="text-gray-700 hover:text-yellow-600 font-semibold">🛠️ الخدمات</a>

        <a href="{{ route('emergency_services.index') }}"
           class="text-white bg-pink-500 hover:bg-pink-600 px-4 py-2 rounded-md font-bold shadow-md transition">
          🆘 دلني عاجل
        </a>

        <a href="{{ route('contact') }}" class="text-gray-700 hover:text-yellow-600 font-semibold">📞 اتصل بنا</a>

        @auth
          <a href="{{ $dashboardHref }}"
             class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md font-semibold shadow">🙍‍♂️ حسابي</a>
          <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="text-gray-700 hover:text-red-600 font-semibold ml-2">🔓 تسجيل الخروج</button>
          </form>
        @else
          <a href="{{ route('login') }}"
             class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md font-semibold shadow">🔐 تسجيل الدخول</a>
        @endauth
      </div>

      <!-- Mobile Button -->
      <button class="md:hidden text-2xl text-gray-600 focus:outline-none"
              onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">☰</button>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div class="sm:hidden hidden" id="mobile-menu">
    <div class="px-2 pt-2 pb-3 space-y-1">
      <div class="px-3 pb-2">
        <span class="text-sm">
          🌐
          @if(app()->getLocale()==='ar')
            <a href="{{ $hasLang ? route('change.lang','en') : url('/lang/en') }}"
               class="text-gray-600 hover:text-yellow-600">English</a>
          @else
            <a href="{{ $hasLang ? route('change.lang','ar') : url('/lang/ar') }}"
               class="text-gray-600 hover:text-yellow-600">العربية</a>
          @endif
        </span>
      </div>

      <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-200">🏠 الرئيسية</a>
      <a href="{{ route('ads.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-200">📢 الإعلانات</a>
      <a href="{{ route('about') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-200">📝 عن دلني</a>
      <a href="{{ \Illuminate\Support\Facades\Route::has('services') ? route('services') : url('/services') }}"
         class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-200">🛠️ الخدمات</a>
      <a href="{{ route('emergency_services.index') }}"
         class="block w-full text-center text-white bg-pink-500 hover:bg-pink-600 px-3 py-2 rounded-md font-semibold">🆘 دلني عاجل</a>
      <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-200">📞 اتصل بنا</a>

      @auth
        <a href="{{ $dashboardHref }}"
           class="block w-full text-center bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-md font-semibold">🙍‍♂️ حسابي</a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="block w-full text-center text-red-600 hover:text-red-800 px-3 py-2 rounded-md font-semibold">🔓 تسجيل الخروج</button>
        </form>
      @else
        <a href="{{ route('login') }}"
           class="block w-full text-center bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-md font-semibold">🔐 تسجيل الدخول</a>
      @endauth
    </div>
  </div>
</nav>
