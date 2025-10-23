{{-- resources/views/home.blade.php --}}
<x-app-layout title="Delni.co">
    <div class="max-w-7xl mx-auto px-4 py-8">
{{-- ✅ قسم الدعايات (سلايدر بوسترات Full Width) --}}
<div class="w-full mb-6">
    <div class="swiper mySwiper w-full">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="{{ asset('images/ad-sample-1.jpg') }}" 
                     class="w-full h-40 md:h-72 object-cover" alt="إعلان 1">
            </div>
            <div class="swiper-slide">
                <img src="{{ asset('images/ad-sample-2.jpg') }}" 
                     class="w-full h-40 md:h-72 object-cover" alt="إعلان 2">
            </div>
            <div class="swiper-slide">
                <img src="{{ asset('images/ad-sample-3.jpg') }}" 
                     class="w-full h-40 md:h-72 object-cover" alt="إعلان 3">
            </div>
        </div>
        {{-- ✅ أزرار التنقل --}}
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        {{-- ✅ النقاط --}}
        <div class="swiper-pagination"></div>
    </div>
</div>
        {{-- ✅ التبويبات العلوية (تصنيفات) --}}
        <div class="category-scroll mb-6">
            <a href="{{ route('ads.index', ['category' => 'realestate']) }}" class="category-icon">
                <i class="fas fa-building"></i>
                <span>{{ __('messages.real_estate') }}</span>
            </a>
            <a href="{{ route('ads.index', ['category' => 'cars']) }}" class="category-icon">
                <i class="fas fa-car"></i>
                <span>{{ __('messages.car_parts') }}</span>
            </a>
            <a href="{{ route('ads.index', ['category' => 'services']) }}" class="category-icon">
                <i class="fas fa-tools"></i>
                <span>{{ __('messages.services') }}</span>
            </a>
            <a href="{{ route('mall.index') }}" class="category-icon">
                <i class="fas fa-store"></i>
                <span>{{ __('messages.delni_mall') }}</span>
            </a>
            <a href="{{ route('delni.taxi') }}" class="category-icon">
                <i class="fas fa-taxi"></i>
                <span>{{ __('messages.delni_taxi') }}</span>
            </a>
            <a href="{{ route('emergency.index') }}" class="category-icon">
                <i class="fas fa-ambulance"></i>
                <span>{{ __('messages.delni_emergency') }}</span>
            </a>
        </div>
        {{-- 🔍 شريط البحث --}}
        <form method="GET" action="{{ route('ads.index') }}" 
              class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6 mb-10 border border-gray-200 dark:border-gray-700">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <input type="text" name="city" placeholder="{{ __('messages.search_city') }}" 
                       class="input" value="{{ request('city') }}">
                <input type="number" name="price_min" placeholder="{{ __('messages.price_from') }}" 
                       class="input" value="{{ request('price_min') }}">
                <input type="number" name="price_max" placeholder="{{ __('messages.price_to') }}" 
                       class="input" value="{{ request('price_max') }}">
                <select name="category" class="input">
                    <option value="">{{ __('messages.select_category') }}</option>
                    <option value="realestate">{{ __('messages.real_estate') }}</option>
                    <option value="cars">{{ __('messages.car_parts') }}</option>
                    <option value="services">{{ __('messages.services') }}</option>
                </select>
                <button type="submit" class="btn-yellow">
                    <i class="fas fa-search"></i> {{ __('messages.search') }}
                </button>
            </div>
        </form>
        {{-- 🗺️ خريطة مصغّرة --}}
        <div class="mb-12">
            <h2 class="section-title"><i class="fas fa-map"></i> {{ __('messages.ads_on_map') }}</h2>
            <div id="homeMap" class="w-full h-[400px] rounded-lg shadow"></div>
        </div>
        {{-- ⭐ الإعلانات المميزة --}}
        @if(isset($featuredAds) && $featuredAds->count())
            <h2 class="section-title"><i class="fas fa-star text-yellow-500"></i> {{ __('messages.featured_ads') }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-12">
                @foreach($featuredAds as $ad)
                    @php
                        $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
                        $img = !empty($images[0]) ? asset('storage/'.$images[0]) : asset('storage/placeholder.png');
                    @endphp
                    <a href="{{ route('ads.show', $ad->id) }}" class="card-ad {{ $ad->is_featured ? 'border-yellow-400' : '' }}">
                        <img src="{{ $img }}" alt="featured">
                        <div class="card-body">
                            <h3>{{ $ad->title }}</h3>
                            <p><i class="fas fa-map-marker-alt text-red-500"></i> {{ $ad->city }}</p>
                            <p class="price"><i class="fas fa-dollar-sign"></i> {{ number_format($ad->price) }} {{ __('messages.currency') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
        {{-- 📋 أحدث الإعلانات --}}
        <h2 class="section-title"><i class="fas fa-clock text-yellow-500"></i> {{ __('messages.latest_ads') }}</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($ads as $ad)
                @php
                    $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
                    $img = !empty($images[0]) ? asset('storage/'.$images[0]) : asset('storage/placeholder.png');
                @endphp
                <a href="{{ route('ads.show', $ad->id) }}" class="card-ad">
                    <img src="{{ $img }}" alt="ad">
                    <div class="card-body">
                        <h3>{{ $ad->title }}</h3>
                        <p><i class="fas fa-map-marker-alt text-red-500"></i> {{ $ad->city }}</p>
                        <p class="price"><i class="fas fa-dollar-sign"></i> {{ number_format($ad->price) }} {{ __('messages.currency') }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    {{-- ✅ مكتبات الخرائط --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    {{-- ✅ مكتبة Swiper --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    {{-- ✅ سكربت الخريطة والسلايدر --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // 🗺️ الخريطة
            const map = L.map('homeMap').setView([34.8021, 38.9968], 7);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
            const ads = @json($ads);
            ads.forEach(ad => {
                if (ad.lat && ad.lng) {
                    L.marker([ad.lat, ad.lng]).addTo(map)
                        .bindPopup(`
                            <strong>${ad.title}</strong><br>
                            <i class='fas fa-map-marker-alt text-red-500'></i> ${ad.city}<br>
                            <i class='fas fa-dollar-sign text-green-600'></i> ${ad.price} {{ __('messages.currency') }}
                        `);
                }
            });
            // 🎞️ السلايدر
            new Swiper(".mySwiper", {
                loop: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
        });
    </script>
</x-app-layout>
