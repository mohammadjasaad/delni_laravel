<x-app-layout>
<div class="max-w-7xl mx-auto px-4 py-10">

    <h1 class="text-3xl font-bold text-center text-yellow-600 mb-10">
        🚗 {{ __('messages.cars') }}
    </h1>

    {{-- 🔘 أزرار التحكم --}}
    <div class="flex justify-center gap-4 mb-10">
        <button id="toggleFilter" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">
            ⚙️ {{ __('messages.filters') }}
        </button>
        <button id="toggleMap" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">
            🗺️ {{ __('messages.show_map') }}
        </button>
    </div>

    {{-- 📂 أقسام السيارات --}}
    <h2 class="text-xl font-semibold text-gray-800 mb-4">📂 اختر نوع المركبة</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        <x-service-card icon="🚗" title="مركبات خاصة" desc="سيارات سيدان – هاتشباك – SUV"
            link="{{ route('ads.cars', ['subcategory' => 'private']) }}"/>
        <x-service-card icon="🚛" title="مركبات تجارية" desc="شاحنات – باصات – فانات"
            link="{{ route('ads.cars', ['subcategory' => 'commercial']) }}"/>
        <x-service-card icon="🏍️" title="دراجات نارية" desc="دراجات – سكوتر – ATV"
            link="{{ route('ads.cars', ['subcategory' => 'motorcycle']) }}"/>
    </div>

    {{-- 🔍 الفلترة (مخفية) --}}
    <form id="filterBox" method="GET" action="{{ route('ads.cars') }}"
          class="hidden bg-white shadow-md rounded-2xl p-6 mb-12 w-full max-w-5xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            {{-- 🏭 الشركة المصنعة --}}
            <select name="brand" class="w-full p-3 border rounded-xl text-sm">
                <option value="">اختر الشركة المصنعة</option>
                @foreach(['Audi','BMW','Mercedes-Benz','Toyota','Hyundai','Kia','Ford','Chevrolet','Renault','Volkswagen','Nissan','Honda'] as $brand)
                    <option value="{{ $brand }}" {{ request('brand')==$brand?'selected':'' }}>{{ $brand }}</option>
                @endforeach
            </select>

            {{-- 📅 سنة الصنع --}}
            <select name="year" class="w-full p-3 border rounded-xl text-sm">
                <option value="">اختر سنة الصنع</option>
                @for ($y = now()->year; $y >= 1980; $y--)
                    <option value="{{ $y }}" {{ request('year')==$y?'selected':'' }}>{{ $y }}</option>
                @endfor
            </select>

            {{-- 🆕 الحالة --}}
            <select name="condition" class="w-full p-3 border rounded-xl text-sm">
                <option value="">اختر الحالة</option>
                <option value="new" {{ request('condition')=='new'?'selected':'' }}>جديد</option>
                <option value="used" {{ request('condition')=='used'?'selected':'' }}>مستعمل</option>
            </select>

            {{-- 🌍 المدينة --}}
            <select name="city" class="w-full p-3 border rounded-xl text-sm">
                <option value="">{{ __('messages.select_city') }}</option>
                <optgroup label="🇸🇾 سوريا">
                    <option value="دمشق" {{ request('city')=='دمشق'?'selected':'' }}>دمشق</option>
                    <option value="حلب" {{ request('city')=='حلب'?'selected':'' }}>حلب</option>
                    <option value="حمص" {{ request('city')=='حمص'?'selected':'' }}>حمص</option>
                    <option value="اللاذقية" {{ request('city')=='اللاذقية'?'selected':'' }}>اللاذقية</option>
                    <option value="حماة" {{ request('city')=='حماة'?'selected':'' }}>حماة</option>
                    <option value="طرطوس" {{ request('city')=='طرطوس'?'selected':'' }}>طرطوس</option>
                    <option value="درعا" {{ request('city')=='درعا'?'selected':'' }}>درعا</option>
                    <option value="السويداء" {{ request('city')=='السويداء'?'selected':'' }}>السويداء</option>
                    <option value="ادلب" {{ request('city')=='ادلب'?'selected':'' }}>إدلب</option>
                    <option value="دير الزور" {{ request('city')=='دير الزور'?'selected':'' }}>دير الزور</option>
                    <option value="الرقة" {{ request('city')=='الرقة'?'selected':'' }}>الرقة</option>
                    <option value="الحسكة" {{ request('city')=='الحسكة'?'selected':'' }}>الحسكة</option>
                    <option value="ريف دمشق" {{ request('city')=='ريف دمشق'?'selected':'' }}>ريف دمشق</option>
                </optgroup>
                <optgroup label="🌍 دول أخرى">
                    <option value="تركيا" {{ request('city')=='تركيا'?'selected':'' }}>تركيا</option>
                </optgroup>
            </select>

            {{-- 💰 السعر من --}}
            <input type="number" name="price_min" placeholder="{{ __('messages.price_from') }}"
                   class="w-full p-3 border rounded-xl text-sm" value="{{ request('price_min') }}">

            {{-- 💰 السعر إلى --}}
            <input type="number" name="price_max" placeholder="{{ __('messages.price_to') }}"
                   class="w-full p-3 border rounded-xl text-sm" value="{{ request('price_max') }}">
        </div>

        <div class="flex justify-end mt-4 gap-3">
            <a href="{{ route('ads.cars') }}" 
               class="bg-gray-200 px-6 py-3 rounded-xl hover:bg-gray-300 transition">
               🔄 {{ __('messages.reset_filters') }}
            </a>
            <button type="submit" 
                    class="bg-yellow-500 text-white px-6 py-3 rounded-xl hover:bg-yellow-600 transition">
                🔍 {{ __('messages.search') }}
            </button>
        </div>
    </form>

    {{-- 🗺️ الخريطة (مخفية) --}}
    <div id="mapBox" class="hidden mt-6 mb-12">
        <h2 class="text-2xl font-extrabold text-yellow-600 mb-4 text-center">🗺️ {{ __('messages.ads_on_map') }}</h2>
        <div id="adsMap" class="w-full h-[400px] rounded-lg shadow"></div>
    </div>

    {{-- 🖼️ عرض الإعلانات --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($ads->sortByDesc('created_at') as $ad)
            @php
                $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
                $firstImage = $images[0] ?? 'placeholder.png';
            @endphp
            <div class="relative bg-white rounded-xl shadow hover:shadow-2xl overflow-hidden transition duration-300">
                <a href="{{ route('ads.show', $ad->id) }}">
                    <img src="{{ asset('storage/' . $firstImage) }}" class="w-full h-48 object-cover rounded-t-xl" alt="ad">
                </a>
                <div class="p-4">
                    <h2 class="font-bold text-base truncate text-gray-900">{{ $ad->title }}</h2>
                    <p class="text-gray-500 text-sm">📍 {{ $ad->city }}</p>
                    <p class="text-red-600 font-bold text-sm mt-1">💰 {{ number_format($ad->price) }} {{ __('messages.currency') }}</p>
                    <a href="{{ route('ads.show', $ad->id) }}" 
                       class="block mt-3 text-center bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 rounded-lg transition">
                        {{ __('messages.view_ad') }}
                    </a>
                </div>
            </div>
        @empty
            <p class="text-center col-span-4 text-gray-500 mt-8">{{ __('messages.no_ads_found') }}</p>
        @endforelse
    </div>

    <div class="mt-10">{{ $ads->links() }}</div>
</div>

{{-- ✅ JS Scripts --}}
<script>
    document.getElementById('toggleFilter').addEventListener('click', () => {
        document.getElementById('filterBox').classList.toggle('hidden');
    });
    document.getElementById('toggleMap').addEventListener('click', () => {
        document.getElementById('mapBox').classList.toggle('hidden');
    });
    document.addEventListener("DOMContentLoaded", function () {
        const map = L.map('adsMap').setView([34.8021, 38.9968], 7);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; Delni.co'
        }).addTo(map);
        const ads = @json($ads);
        ads.forEach(ad => {
            if (ad.lat && ad.lng) {
                const marker = L.marker([ad.lat, ad.lng]).addTo(map);
                marker.bindPopup(`<strong>${ad.title}</strong><br>${ad.city}<br>💰 ${ad.price} {{ __('messages.currency') }}`);
            }
        });
    });
</script>
</x-app-layout>
