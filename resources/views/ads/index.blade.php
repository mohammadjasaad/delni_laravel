{{-- resources/views/ads/index.blade.php --}}
<x-app-layout>
<div class="w-full px-4 lg:px-24 xl:px-36 py-8">

    {{-- ✅ التبويبات العلوية --}}
    <div class="flex flex-wrap items-center justify-center gap-3 mb-6">
        <a href="{{ route('ads.index', ['category' => 'realestate']) }}" class="tab-link {{ request('category')=='realestate' ? 'active' : '' }}">
            <i class="fas fa-building"></i> {{ __('messages.real_estate') }}
        </a>
        <a href="{{ route('ads.index', ['category' => 'cars']) }}" class="tab-link {{ request('category')=='cars' ? 'active' : '' }}">
            <i class="fas fa-car"></i> {{ __('messages.cars') }}
        </a>
        <a href="{{ route('ads.index', ['category' => 'services']) }}" class="tab-link {{ request('category')=='services' ? 'active' : '' }}">
            <i class="fas fa-tools"></i> {{ __('messages.services') }}
        </a>
        <a href="{{ route('delni.taxi') }}" class="tab-link {{ request()->routeIs('delni.taxi') ? 'active' : '' }}">
            <i class="fas fa-taxi"></i> {{ __('messages.delni_taxi') }}
        </a>
<a href="{{ route('emergency_services.index') }}" class="tab-link {{ request()->routeIs('emergency_services.*') ? 'active' : '' }}">
    <i class="fas fa-ambulance"></i> {{ __('messages.delni_emergency') }}
</a>
    </div>

    {{-- 🔘 أزرار التحكم --}}
    <div class="flex justify-center gap-4 mb-6">
        <button id="toggleFilter" class="btn-yellow">
            <i class="fas fa-sliders-h"></i> {{ __('messages.filters') }}
        </button>
        <button id="toggleMap" class="btn-yellow">
            <i class="fas fa-map-marked-alt"></i> {{ __('messages.show_map') }}
        </button>
    </div>

    {{-- 🔍 الفلترة --}}
    <form id="filterBox" method="GET" action="{{ route('ads.index') }}" 
          class="hidden bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6 mb-12 w-full max-w-6xl mx-auto"
          x-data="{ category: '{{ request('category') ?? '' }}' }">

        {{-- 🌍 المدينة + التصنيف + السعر --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <select name="city" class="input">
                <option value="">{{ __('messages.select_city') }}</option>
                @foreach(['دمشق','ريف دمشق','حلب','حمص','حماة','اللاذقية','طرطوس','درعا','السويداء','القنيطرة','إدلب','الرقة','دير الزور','الحسكة','تركيا'] as $city)
                    <option value="{{ $city }}" {{ request('city')==$city?'selected':'' }}>{{ $city }}</option>
                @endforeach
            </select>

            <select name="category" x-model="category" class="input">
                <option value="">{{ __('messages.select_category') }}</option>
                <option value="realestate" {{ request('category')=='realestate'?'selected':'' }}>🏢 {{ __('messages.real_estate') }}</option>
                <option value="cars" {{ request('category')=='cars'?'selected':'' }}>🚗 {{ __('messages.cars') }}</option>
                <option value="services" {{ request('category')=='services'?'selected':'' }}>🛠️ {{ __('messages.services') }}</option>
            </select>

            <input type="number" name="price_min" placeholder="{{ __('messages.price_from') }}" class="input" value="{{ request('price_min') }}">
            <input type="number" name="price_max" placeholder="{{ __('messages.price_to') }}" class="input" value="{{ request('price_max') }}">
        </div>

        {{-- 🏠 فلترة إضافية حسب التصنيف --}}
        <div x-show="category === 'realestate'" class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <select name="subcategory" class="input">
                <option value="">{{ __('messages.select_subcategory') }}</option>
                <option value="residential" {{ request('subcategory')=='residential'?'selected':'' }}>سكني</option>
                <option value="shop" {{ request('subcategory')=='shop'?'selected':'' }}>محل تجاري</option>
                <option value="land" {{ request('subcategory')=='land'?'selected':'' }}>أرض</option>
                <option value="villa" {{ request('subcategory')=='villa'?'selected':'' }}>فيلا</option>
                <option value="office" {{ request('subcategory')=='office'?'selected':'' }}>مكتب</option>
                <option value="building" {{ request('subcategory')=='building'?'selected':'' }}>بناء</option>
            </select>
            <select name="deal_type" class="input">
                <option value="">{{ __('messages.deal_type') }}</option>
                <option value="sale" {{ request('deal_type')=='sale'?'selected':'' }}>بيع</option>
                <option value="rent" {{ request('deal_type')=='rent'?'selected':'' }}>إيجار</option>
            </select>
            <input type="number" name="area_min" placeholder="{{ __('messages.area_from') }}" class="input" value="{{ request('area_min') }}">
            <input type="number" name="area_max" placeholder="{{ __('messages.area_to') }}" class="input" value="{{ request('area_max') }}">
        </div>

        <div x-show="category === 'cars'" class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <select name="car_brand" class="input">
                <option value="">{{ __('messages.select_car_brand') }}</option>
                @foreach(['Audi','BMW','Mercedes-Benz','Toyota','Hyundai','Kia','Renault','Nissan','Volkswagen','Volvo','Chevrolet','Ford','Honda','Mazda'] as $brand)
                    <option value="{{ $brand }}" {{ request('car_brand')==$brand?'selected':'' }}>{{ $brand }}</option>
                @endforeach
            </select>
            <select name="car_year" class="input">
                <option value="">{{ __('messages.select_car_year') }}</option>
                @for ($y = date('Y'); $y >= 1980; $y--)
                    <option value="{{ $y }}" {{ request('car_year')==$y?'selected':'' }}>{{ $y }}</option>
                @endfor
            </select>
            <select name="fuel" class="input">
                <option value="">{{ __('messages.fuel') }}</option>
                <option value="بنزين" {{ request('fuel')=='بنزين'?'selected':'' }}>بنزين</option>
                <option value="ديزل" {{ request('fuel')=='ديزل'?'selected':'' }}>ديزل</option>
                <option value="كهرباء" {{ request('fuel')=='كهرباء'?'selected':'' }}>كهرباء</option>
                <option value="هجين" {{ request('fuel')=='هجين'?'selected':'' }}>هجين</option>
            </select>
        </div>

        <div x-show="category === 'services'" class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <input type="text" name="service_type" placeholder="{{ __('messages.service_type') }}" class="input" value="{{ request('service_type') }}">
            <input type="text" name="provider_name" placeholder="{{ __('messages.provider_name') }}" class="input" value="{{ request('provider_name') }}">
        </div>

        {{-- ⭐ حالة الإعلان + الترتيب --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <select name="featured" class="input">
                <option value="">{{ __('messages.featured_status') }}</option>
                <option value="1" {{ request('featured')=='1'?'selected':'' }}>⭐ {{ __('messages.featured') }}</option>
                <option value="0" {{ request('featured')=='0'?'selected':'' }}>⚪ {{ __('messages.normal') }}</option>
            </select>
            <select name="sort" class="input">
                <option value="latest" {{ request('sort')=='latest'?'selected':'' }}>🆕 {{ __('messages.latest') }}</option>
                <option value="price_desc" {{ request('sort')=='price_desc'?'selected':'' }}>⬆️ {{ __('messages.price_high') }}</option>
                <option value="price_asc" {{ request('sort')=='price_asc'?'selected':'' }}>⬇️ {{ __('messages.price_low') }}</option>
            </select>
        </div>

        <div class="flex justify-end mt-4 gap-3">
            <a href="{{ route('ads.index') }}" class="btn-gray">
                <i class="fas fa-undo"></i> {{ __('messages.reset_filters') }}
            </a>
            <button type="submit" class="btn-yellow">
                <i class="fas fa-search"></i> {{ __('messages.search') }}
            </button>
        </div>
    </form>

    {{-- 🗺️ الخريطة --}}
    <div id="mapBox" class="hidden mt-6 mb-12">
        <h2 class="section-title text-center">
            <i class="fas fa-map"></i> {{ __('messages.ads_on_map') }}
        </h2>
        <div id="adsMap" class="w-full h-[400px] rounded-lg shadow"></div>
    </div>

    {{-- 🖼️ عرض الإعلانات --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($ads as $ad)
            @php
                $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
                $firstImage = !empty($images[0]) ? asset('storage/'.$images[0]) : asset('storage/placeholder.png');
            @endphp
<div class="ad-card relative {{ $ad->is_featured ? 'border-yellow-400':'border-gray-200 dark:border-gray-700' }}">
    {{-- ⭐ إعلان مميز --}}
    @if($ad->is_featured)
        <span class="badge-featured"><i class="fas fa-star"></i></span>
    @endif

    {{-- ❤️ زر المفضلة --}}
    <div class="absolute top-2 left-2 z-10">
        @auth
            @if(auth()->user()->favorites->contains($ad->id))
                {{-- إذا الإعلان موجود بالمفضلة --}}
                <form action="{{ route('ads.unfavorite', $ad->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-gray-400 transition">
                        <i class="fas fa-heart fa-lg"></i>
                    </button>
                </form>
            @else
                {{-- إذا الإعلان غير موجود بالمفضلة --}}
                <form action="{{ route('ads.favorite', $ad->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-red-600 transition">
                        <i class="far fa-heart fa-lg"></i>
                    </button>
                </form>
            @endif
        @endauth
    </div>

    {{-- صورة الإعلان --}}
    <a href="{{ route('ads.show', $ad->id) }}">
        <img src="{{ $firstImage }}" class="w-full h-48 object-cover rounded-t-xl" alt="ad">
    </a>

    {{-- تفاصيل الإعلان --}}
    <div class="p-4 flex flex-col justify-between flex-1">
        <h2 class="font-bold text-base truncate text-gray-900 dark:text-white">{{ $ad->title }}</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm">
            <i class="fas fa-map-marker-alt text-red-500"></i> {{ $ad->city }}
        </p>
        <p class="text-red-600 font-bold text-sm mt-1">
            <i class="fas fa-dollar-sign"></i> {{ number_format($ad->price) }} {{ __('messages.currency') }}
        </p>
        <a href="{{ route('ads.show', $ad->id) }}" class="block mt-3 text-center btn-yellow">
            <i class="fas fa-eye"></i> {{ __('messages.view_ad') }}
        </a>
    </div>
</div>

        @empty
            <p class="text-center col-span-4 text-gray-500 mt-8">
                <i class="fas fa-exclamation-circle"></i> {{ __('messages.no_ads_found') }}
            </p>
        @endforelse
    </div>

    {{-- 📄 روابط التصفح --}}
    <div class="mt-10">
        {{ $ads->links() }}
    </div>
</div>

{{-- ✅ Leaflet --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.getElementById('toggleFilter').addEventListener('click', () => {
        document.getElementById('filterBox').classList.toggle('hidden');
    });

    document.getElementById('toggleMap').addEventListener('click', () => {
        document.getElementById('mapBox').classList.toggle('hidden');
    });

    document.addEventListener("DOMContentLoaded", function () {
        const map = L.map('adsMap').setView([34.8021, 38.9968], 7);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; Delni.co' }).addTo(map);

        fetch("{{ route('ads.mapData') }}")
            .then(res => res.json())
            .then(data => {
                data.forEach(ad => {
                    if (ad.lat && ad.lng) {
                        const marker = L.marker([ad.lat, ad.lng]).addTo(map);
                        const popupContent = `
                            <img src="${ad.first_image ?? '{{ asset('storage/placeholder.png') }}'}" style="width:100px;height:70px;object-fit:cover;border-radius:8px;margin-bottom:5px;">
                            <strong>${ad.title}</strong><br>
                            <i class='fas fa-map-marker-alt text-red-500'></i> ${ad.city}<br>
                            <i class='fas fa-dollar-sign text-green-600'></i> ${ad.price} {{ __('messages.currency') }}<br>
                            <a href="/ads/${ad.id}" class="text-blue-600 underline">
                                <i class='fas fa-eye'></i> {{ __('messages.view_ad') }}
                            </a>
                        `;
                        marker.bindPopup(popupContent);
                    }
                });
            })
            .catch(err => console.error("⚠️ خطأ بجلب بيانات الخريطة:", err));
    });
</script>
</x-app-layout>
