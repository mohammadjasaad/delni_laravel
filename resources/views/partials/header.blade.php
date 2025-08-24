{{-- هذا الهيدر تُرِك اختياريًا لتوافق الصفحات القديمة.
    لن يُعرض إلا إذا استدعيتَه مع المتغير: ['show_legacy_header' => true] --}}

@if(!empty($show_legacy_header))
<header class="bg-white shadow-sm">
  <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between gap-4">

    {{-- 🌐 مُبدّل اللغة --}}
    <div class="text-sm flex items-center gap-2">
      <span>🌐</span>
      @if(app()->getLocale()==='ar')
        <a href="{{ route('change.lang','en') }}" class="text-gray-600 hover:text-yellow-600">
          {{ __('messages.lang_en') }}
        </a>
      @else
        <a href="{{ route('change.lang','ar') }}" class="text-gray-600 hover:text-yellow-600">
          {{ __('messages.lang_ar') }}
        </a>
      @endif
    </div>

    {{-- الشعار --}}
    <a href="{{ route('home') }}" class="flex items-center gap-2">
      <img src="{{ asset('images/delni-logo.png') }}" alt="{{ __('messages.logo_alt') }}" class="h-9">
      <span class="text-xl font-bold text-gray-800">Delni.co</span>
    </a>

    {{-- روابط سريعة (تُخفى على الشاشات الصغيرة) --}}
    <nav class="hidden md:flex items-center gap-6 text-sm">
      <a href="{{ route('ads.index') }}"
         class="text-gray-700 hover:text-yellow-600 {{ request()->routeIs('ads.*') ? 'font-semibold text-yellow-600' : '' }}">
        {{ __('messages.real_estate') }} / {{ __('messages.cars') }}
      </a>

      <a href="{{ route('emergency_services.index') }}"
         class="text-gray-700 hover:text-yellow-600 {{ request()->routeIs('emergency_services.*') ? 'font-semibold text-yellow-600' : '' }}">
        Delni Emergency
      </a>

      <a href="{{ route('contact') }}"
         class="text-gray-700 hover:text-yellow-600 {{ request()->routeIs('contact') ? 'font-semibold text-yellow-600' : '' }}">
        {{ __('messages.contact_us') }}
      </a>
    </nav>

    {{-- يمين الهيدر: زر تاكسي + حساب --}}
    <div class="flex items-center gap-3">
      {{-- زر Delni Taxi --}}
      <a href="{{ route('taxi.landing') }}"
         class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-yellow-500 text-white hover:bg-yellow-600 text-sm">
        🚖 <span class="font-semibold">{{ __('messages.delni_taxi') }}</span>
      </a>

      @auth
        <a href="{{ route('dashboard.index') }}"
           class="bg-gray-100 text-gray-800 px-3 py-1.5 rounded hover:bg-gray-200 text-sm">
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
@endif
