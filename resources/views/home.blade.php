<x-guest-layout>
    <div class="w-full px-4 lg:px-24 xl:px-36 py-8">

        {{-- ✅ التبويبات العلوية مع Delni Taxi --}}
        <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('home', ['filter' => 'realestate']) }}"
                   class="px-4 py-2 rounded-full whitespace-nowrap transition 
                   {{ request('filter') == 'realestate' ? 'bg-yellow-400 text-black font-bold' : 'bg-gray-200 text-gray-700' }}">
                    🏠 {{ __('messages.real_estate') }}
                </a>
                <a href="{{ route('home', ['filter' => 'cars']) }}"
                   class="px-4 py-2 rounded-full whitespace-nowrap transition 
                   {{ request('filter') == 'cars' ? 'bg-yellow-400 text-black font-bold' : 'bg-gray-200 text-gray-700' }}">
                    🚗 {{ __('messages.cars') }}
                </a>
                <a href="{{ route('home', ['filter' => 'services']) }}"
                   class="px-4 py-2 rounded-full whitespace-nowrap transition 
                   {{ request('filter') == 'services' ? 'bg-yellow-400 text-black font-bold' : 'bg-gray-200 text-gray-700' }}">
                    🛠️ {{ __('messages.services') }}
                </a>
                <a href="{{ route('taxi.request') }}"
                   class="px-4 py-2 rounded-full whitespace-nowrap transition 
                   {{ request()->routeIs('taxi.request') ? 'bg-yellow-400 text-black font-bold' : 'bg-gray-200 text-gray-700' }}">
                    🚖 Delni Taxi
                </a>
                <a href="{{ route('emergency.index') }}"
                   class="px-4 py-2 rounded-full whitespace-nowrap transition 
                   {{ request()->routeIs('emergency.index') ? 'bg-yellow-400 text-black font-bold' : 'bg-gray-200 text-gray-700' }}">
                   🚨 دلني عاجل
                </a>
            </div>

            {{-- 🌐 اللغة --}}
            <div class="text-sm whitespace-nowrap">
                <a href="{{ route('lang.switch', 'ar') }}" class="mx-1 {{ app()->getLocale() == 'ar' ? 'font-bold underline' : '' }}">العربية</a> |
                <a href="{{ route('lang.switch', 'en') }}" class="mx-1 {{ app()->getLocale() == 'en' ? 'font-bold underline' : '' }}">English</a>
            </div>
        </div>

        {{-- 🔍 مربع البحث --}}
        <form method="GET" action="{{ route('home') }}" class="bg-white shadow-md rounded-2xl p-6 mb-8 w-full max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-center">
                <input type="text" name="city" placeholder="{{ __('messages.search_city') }}"
                       class="w-full p-3 border rounded-xl text-sm" value="{{ request('city') }}">

                <input type="number" name="price_min" placeholder="{{ __('messages.price_from') }}"
                       class="w-full p-3 border rounded-xl text-sm" value="{{ request('price_min') }}">

                <input type="number" name="price_max" placeholder="{{ __('messages.price_to') }}"
                       class="w-full p-3 border rounded-xl text-sm" value="{{ request('price_max') }}">

                <select name="category" class="w-full p-3 border rounded-xl text-sm">
                    <option value="">{{ __('messages.select_category') }}</option>
                    <option value="realestate" {{ request('category') == 'realestate' ? 'selected' : '' }}>{{ __('messages.real_estate') }}</option>
                    <option value="cars" {{ request('category') == 'cars' ? 'selected' : '' }}>{{ __('messages.cars') }}</option>
                    <option value="services" {{ request('category') == 'services' ? 'selected' : '' }}>{{ __('messages.services') }}</option>
                </select>

                <button type="submit" class="bg-red-500 text-white px-4 py-3 rounded-xl hover:bg-red-600 text-sm flex justify-center items-center gap-1">
                    🔍 {{ __('messages.search') }}
                </button>
            </div>
        </form>

        {{-- 🗺️ خريطة الإعلانات --}}
        <div class="mt-10 mb-16">
            <h2 class="text-2xl font-bold text-yellow-600 mb-4 text-center">🗺️ عرض الإعلانات على الخريطة</h2>
            <div id="adsMap" class="w-full h-[500px] rounded-lg shadow"></div>
        </div>
{{-- ⭐ الإعلانات المميزة --}}
@if ($featuredAds->count() > 0)
    <div class="mt-12">
        <h2 class="text-2xl font-bold text-yellow-600 mb-6 text-center">⭐ {{ __('messages.featured_ads') }}</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach ($featuredAds as $ad)
                <div class="relative bg-white border border-yellow-300 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition">

{{-- 🎗 شريط مائل "مميز" مع تأثير نبض --}}
<div class="absolute top-0 right-0 z-10">
    <div class="animate-pulse bg-yellow-400 text-white text-xs font-bold px-8 py-1 transform rotate-45 translate-x-8 -translate-y-4 shadow-md">
        ⭐ مميز
    </div>
</div>

                    <img src="{{ asset('storage/' . $ad->images[0]) }}" alt="ad image" class="w-full h-40 object-cover">

                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800 truncate">{{ $ad->title }}</h3>
                        <p class="text-sm text-gray-500">{{ $ad->city }}</p>
                        <p class="text-red-600 font-bold mt-2">{{ $ad->price }} {{ __('messages.currency') }}</p>
                        <a href="{{ route('ads.show', $ad->id) }}" class="block mt-4 text-center bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 rounded">
                            {{ __('messages.view_ad') }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

        {{-- 🖼️ عرض الإعلانات --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($ads as $ad)
                <div class="bg-white rounded-xl shadow hover:shadow-lg overflow-hidden transition duration-300">
@php
    $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
@endphp

<img src="{{ isset($images[0]) ? asset('storage/' . $images[0]) : '/placeholder.png' }}"
     alt="image"
     class="w-full h-48 object-cover">

@if(isset($featuredAds) && $featuredAds->count() > 0)
    {{-- كود عرض الإعلانات المميزة --}}
@endif

                    <div class="p-4">
                        <h2 class="font-semibold text-base truncate mb-1">{{ $ad->title }}</h2>
                        <p class="text-gray-600 text-sm">{{ $ad->city }}</p>
                        <p class="text-red-600 font-bold text-sm mt-2">{{ number_format($ad->price) }} {{ __('messages.currency') }}</p>
                        <p class="text-gray-400 text-xs mt-1">{{ __('messages.category') }}: {{ ucfirst($ad->category) }}</p>
                    </div>
                </div>
            @empty
                <p class="text-center col-span-4 text-gray-500 mt-8">{{ __('messages.no_ads_found') }}</p>
            @endforelse
        </div>
    </div>

    {{-- ✅ مكتبة Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    {{-- ✅ كود الخريطة --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const map = L.map('adsMap').setView([34.8021, 38.9968], 7); // مركز سوريا

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; Delni.co'
            }).addTo(map);

            const ads = @json($ads);

            ads.forEach(ad => {
                if (ad.lat && ad.lng) {
                    const marker = L.marker([ad.lat, ad.lng]).addTo(map);
const img = ad.images && ad.images.length > 0
    ? `<img src="/storage/${ad.images[0]}" alt="" style='width:100px;height:70px;object-fit:cover;border-radius:8px;margin-bottom:5px;'>`
    : `<img src="/placeholder.png" alt="" style='width:100px;height:70px;object-fit:cover;border-radius:8px;margin-bottom:5px;'>`;

marker.bindPopup(`
    ${img}
    <strong>${ad.title}</strong><br>
    ${ad.city}<br>
    💰 ${ad.price} {{ __('messages.currency') }}<br>
    <a href="/ads/${ad.id}" class="text-blue-600 underline">عرض الإعلان</a>
`);

                }
            });
        });
    </script>
</x-guest-layout>
