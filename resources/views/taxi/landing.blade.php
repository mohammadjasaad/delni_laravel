{{-- resources/views/taxi/landing.blade.php --}}
<x-main-layout title="{{ __('messages.taxi_service_title') }}">
    <div class="max-w-5xl mx-auto px-4 py-12 text-center">

        {{-- العنوان --}}
        <h1 class="text-3xl font-bold mb-4 text-yellow-600">{{ __('messages.taxi_service_title') }}</h1>
        <p class="text-gray-700 text-lg sm:text-xl mb-8 leading-relaxed">
            {{ __('messages.taxi_service_description') }}
        </p>

        {{-- ✅ دعوة للفعل (جديدة + غير مكسِّرة لأي شيء) --}}
        <div class="flex justify-center items-center gap-3 mb-10 flex-wrap">
            <a href="{{ route('taxi.order.map') }}"
               class="px-6 py-2.5 rounded-full bg-yellow-500 text-white hover:bg-yellow-600 text-base font-semibold">
               {{ __('messages.order_now') ?? 'اطلب سيارة الآن' }}
            </a>
            <a href="{{ route('drivers.map') }}"
               class="px-6 py-2.5 rounded-full bg-gray-100 text-gray-800 hover:bg-gray-200 text-base font-semibold">
               {{ __('messages.drivers_map') ?? 'خريطة السائقين' }}
            </a>
        </div>

        {{-- الميزات --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-left text-gray-700 mb-12">
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-xl font-semibold mb-2">⭐ {{ __('messages.feature_driver_ratings') }}</h3>
                <p>{{ __('messages.feature_driver_ratings_desc') }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-xl font-semibold mb-2">📍 {{ __('messages.feature_live_tracking') }}</h3>
                <p>{{ __('messages.feature_live_tracking_desc') }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-xl font-semibold mb-2">💳 {{ __('messages.feature_online_payment') }}</h3>
                <p>{{ __('messages.feature_online_payment_desc') }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-xl font-semibold mb-2">🔒 {{ __('messages.feature_safety') }}</h3>
                <p>{{ __('messages.feature_safety_desc') }}</p>
            </div>
        </div>

        {{-- أزرار التحميل --}}
        <div class="flex justify-center items-center gap-4 mb-8 flex-wrap">
            <a href="https://play.google.com/store/apps/details?id=delni.app" target="_blank" rel="noopener">
                <img src="{{ asset('images/google-play.png') }}" alt="Google Play" class="h-16">
            </a>
            <a href="https://apps.apple.com/app/id123456789" target="_blank" rel="noopener">
                <img src="{{ asset('images/app-store.png') }}" alt="App Store" class="h-16">
            </a>
        </div>

        {{-- QR كود --}}
        <div class="mb-12">
            <img src="{{ asset('images/delni-taxi-qr.png') }}" alt="QR Code" class="mx-auto h-20 w-20">
            <p class="text-sm text-gray-500 mt-2">{{ __('messages.scan_qr') }}</p>
        </div>

        {{-- صورة التطبيق --}}
        <div class="flex justify-center gap-6 flex-wrap">
            <img src="{{ asset('images/app-screenshot2.png') }}" alt="App Screenshot 2" class="rounded-lg shadow-lg max-w-xs">
        </div>

        {{-- زر دعوة للعمل (ابقيناه كما هو) --}}
        <div class="mt-12">
            <a href="https://play.google.com/store/apps/details?id=delni.app" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-full text-lg font-semibold shadow">
                {{ __('messages.download_app') }}
            </a>
        </div>

    </div>
</x-main-layout>
