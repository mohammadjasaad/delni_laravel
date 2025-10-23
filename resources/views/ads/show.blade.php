{{-- resources/views/ads/show.blade.php --}}
<x-app-layout>
<div class="max-w-6xl mx-auto px-4 py-8">
    {{-- ✅ الصور --}}
    @php
        $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
        $mainImage = !empty($images[0]) ? asset('storage/'.$images[0]) : asset('storage/placeholder.png');
    @endphp
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
{{-- 🖼️ الصورة الرئيسية + الصور الإضافية --}}
<div x-data="{ mainImage: '{{ $mainImage }}' }">
    
    {{-- ✅ الصورة الرئيسية (تفتح سلايد شو) --}}
    <a :href="mainImage" data-lightbox="ad-gallery" data-title="{{ $ad->title }}">
        <img :src="mainImage" id="mainImage"
             class="w-full h-96 object-cover rounded-xl shadow cursor-pointer" 
             alt="{{ $ad->title }}">
    </a>
    {{-- 📸 الصور الإضافية --}}
    @if($images && count($images) > 1)
        <div class="flex gap-2 mt-3 overflow-x-auto">
            @foreach($images as $img)
                <img src="{{ asset('storage/'.$img) }}"
                     class="w-28 h-20 object-cover rounded border hover:scale-105 transition cursor-pointer"
                     alt="{{ $ad->title }}"
                     onclick="document.getElementById('mainImage').src=this.src;
                              document.querySelector('a[data-lightbox=\'ad-gallery\']').href=this.src;">
            @endforeach
        </div>
    @endif
{{-- 👤 بطاقة المعلن (أسفل الصور مباشرة) --}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 mb-6 flex items-center justify-between">
    <div>
        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">
            {{ $ad->user->name ?? 'مستخدم' }}
        </h3>
        <p class="text-sm text-gray-600 dark:text-gray-400">
            📞 {{ $ad->user->phone ?? 'لا يوجد رقم' }}
        </p>
        <p class="text-xs text-gray-500 dark:text-gray-400">
            {{ $ad->user->ads()->count() }} إعلان
        </p>
    </div>
<a href="{{ route('user.ads', $ad->user->id) }}" 
   class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-1.5 rounded-md shadow text-sm font-medium">
    <i class="fas fa-list"></i> {{ __('messages.view_all_ads') }}
</a>
</div>
</div>
        {{-- ✅ تفاصيل الإعلان --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-3">
    <i class="fas fa-bullhorn"></i> {{ $ad->title }}
</h1>
<p class="text-gray-500 dark:text-gray-300 mb-2">
    <i class="fas fa-map-marker-alt text-red-500"></i> {{ $ad->city }}
</p>
            <p class="text-red-600 text-xl font-bold mb-4"><i class="fas fa-dollar-sign"></i> {{ number_format($ad->price) }} {{ __('messages.currency') }}</p>
            {{-- ⭐ إعلان مميز --}}
            @if($ad->is_featured)
                <span class="inline-block bg-yellow-400 text-black text-xs font-bold px-3 py-1 rounded-full mb-4">
                    <i class="fas fa-star"></i> {{ __('messages.featured') }}
                </span>
            @endif
            {{-- ✅ التبويبات --}}
            <div x-data="{ tab: 'details' }" class="mt-4">
                <div class="flex gap-6 border-b mb-4">
                    <button @click="tab='details'" :class="tab==='details' ? 'border-b-2 border-yellow-500 font-bold text-yellow-600' : ''" class="pb-2 flex items-center gap-1">
                        <i class="fas fa-info-circle"></i> {{ __('messages.details') }}
                    </button>
                    <button @click="tab='description'" :class="tab==='description' ? 'border-b-2 border-yellow-500 font-bold text-yellow-600' : ''" class="pb-2 flex items-center gap-1">
                        <i class="fas fa-align-left"></i> {{ __('messages.description') }}
                    </button>
<button @click="tab='map'; setTimeout(()=>map.invalidateSize(),300)" 
        :class="tab==='map' ? 'border-b-2 border-yellow-500 font-bold text-yellow-600' : ''" 
        class="pb-2 flex items-center gap-1">
    <i class="fas fa-map"></i> {{ __('messages.location') }}
</button>
                </div>
                {{-- 📑 تبويب التفاصيل --}}
                <div x-show="tab==='details'" class="space-y-4">
                    {{-- 🏠 عقارات --}}
                    @if($ad->category === 'عقارات' || $ad->category === 'realestate')
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                            <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-gray-100">
                                <i class="fas fa-home"></i> {{ __('messages.real_estate_details') }}
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700 dark:text-gray-200">
                                <p><i class="fas fa-tag text-gray-500"></i> {{ __('messages.subcategory') }}: {{ $ad->subcategory ?? '-' }}</p>
                                <p><i class="fas fa-bed text-gray-500"></i> {{ __('messages.rooms') }}: {{ $ad->rooms ?? '-' }}</p>
                                <p><i class="fas fa-bath text-gray-500"></i> {{ __('messages.bathrooms') }}: {{ $ad->bathrooms ?? '-' }}</p>
<p><i class="fas fa-ruler-combined text-gray-500"></i> 
   {{ __('messages.area_total') }}: {{ $ad->area_total ?? '-' }} م²
</p>
<p><i class="fas fa-ruler-combined text-gray-500"></i> 
   {{ __('messages.area_net') }}: {{ $ad->area_net ?? '-' }} م²
</p>
                                <p><i class="fas fa-building text-gray-500"></i> {{ __('messages.floor') }}: {{ $ad->floor ?? '-' }}</p>
                                <p><i class="fas fa-industry text-gray-500"></i> {{ __('messages.building_age') }}: {{ $ad->building_age ?? '-' }}</p>
                                <p><i class="fas fa-elevator text-gray-500"></i> {{ __('messages.elevator') }}: {{ $ad->has_elevator ? __('messages.yes') : __('messages.no') }}</p>
                                <p><i class="fas fa-parking text-gray-500"></i> {{ __('messages.parking') }}: {{ $ad->has_parking ? __('messages.yes') : __('messages.no') }}</p>
                                <p><i class="fas fa-fire text-gray-500"></i> {{ __('messages.heating') }}: {{ $ad->heating_type ?? '-' }}</p>
                            </div>
                        </div>
                    {{-- 🚗 سيارات --}}
                    @elseif($ad->category === 'سيارات' || $ad->category === 'cars')
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                            <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-gray-100">
                                <i class="fas fa-car"></i> {{ __('messages.car_details') }}
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700 dark:text-gray-200">
                                <p><i class="fas fa-car-side text-gray-500"></i> {{ __('messages.car_model') }}: {{ $ad->car_model ?? '-' }}</p>
                                <p><i class="fas fa-calendar-alt text-gray-500"></i> {{ __('messages.car_year') }}: {{ $ad->car_year ?? '-' }}</p>
                                <p><i class="fas fa-tachometer-alt text-gray-500"></i> {{ __('messages.car_km') }}: {{ $ad->car_km ? $ad->car_km.' كم' : '-' }}</p>
                                <p><i class="fas fa-gas-pump text-gray-500"></i> {{ __('messages.fuel') }}: {{ $ad->fuel ?? '-' }}</p>
                                <p><i class="fas fa-cogs text-gray-500"></i> {{ __('messages.gearbox') }}: {{ $ad->gearbox ?? '-' }}</p>
                                <p><i class="fas fa-palette text-gray-500"></i> {{ __('messages.color') }}: {{ $ad->car_color ?? '-' }}</p>
                                <p><i class="fas fa-check-circle text-gray-500"></i> {{ __('messages.condition') }}: {{ $ad->is_new ? __('messages.new') : __('messages.used') }}</p>
                            </div>
                        </div>
                    {{-- 🛠️ خدمات --}}
                    @elseif($ad->category === 'خدمات' || $ad->category === 'services')
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                            <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-gray-100">
                                <i class="fas fa-tools"></i> {{ __('messages.service_details') }}
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700 dark:text-gray-200">
                                <p><i class="fas fa-wrench text-gray-500"></i> {{ __('messages.service_type') }}: {{ $ad->service_type ?? '-' }}</p>
                                <p><i class="fas fa-user-tie text-gray-500"></i> {{ __('messages.provider_name') }}: {{ $ad->provider_name ?? '-' }}</p>
                                <p><i class="fas fa-car text-gray-500"></i> {{ __('messages.vehicle_type') }}: {{ $ad->vehicle_type ?? '-' }}</p>
                                <p><i class="fas fa-shield-alt text-gray-500"></i> {{ __('messages.insurance_type') }}: {{ $ad->insurance_type ?? '-' }}</p>
                                <p><i class="fas fa-tools text-gray-500"></i> {{ __('messages.maintenance_type') }}: {{ $ad->maintenance_type ?? '-' }}</p>
                                <p><i class="fas fa-home text-gray-500"></i> {{ __('messages.property_type') }}: {{ $ad->property_type ?? '-' }}</p>
                                <p><i class="fas fa-gavel text-gray-500"></i> {{ __('messages.bidding_type') }}: {{ $ad->bidding_type ?? '-' }}</p>
                                <p><i class="fas fa-headset text-gray-500"></i> {{ __('messages.support_type') }}: {{ $ad->support_type ?? '-' }}</p>
                            </div>
                        </div>
                    @else
                        <p><i class="fas fa-folder-open text-gray-500"></i> {{ $ad->category }}</p>
                    @endif
                </div>
                {{-- 📝 تبويب الوصف --}}
<div x-show="tab==='description'" class="text-gray-700 dark:text-gray-200 leading-relaxed">
                    {{ $ad->description ?: __('messages.no_description') }}
                </div>
                {{-- 🗺️ تبويب الخريطة --}}
                <div x-show="tab==='map'" class="mt-4">
                  <div id="map" class="w-full h-[400px] md:h-[500px] rounded-lg shadow"></div>
                </div>
            </div>
{{-- ✅ أزرار الاتصال والمفضلة والمشاركة --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-6">
    {{-- زر الاتصال --}}
    <a href="tel:{{ $ad->user->phone ?? '' }}" 
       class="btn-yellow bg-green-500 hover:bg-green-600 w-full text-center">
        <i class="fas fa-phone"></i> {{ __('messages.call') }}
    </a>
@auth
    @if(auth()->user()->favorites()->where('ad_id', $ad->id)->exists())
        {{-- زر إزالة من المفضلة --}}
        <form method="POST" action="{{ route('ads.unfavorite', $ad->slug) }}" class="w-full">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-yellow bg-red-500 hover:bg-red-600 w-full text-center">
                <i class="fas fa-heart-broken"></i> {{ __('messages.remove_favorite') }}
            </button>
        </form>
    @else
        {{-- زر إضافة للمفضلة --}}
        <form method="POST" action="{{ route('ads.favorite', $ad->slug) }}" class="w-full">
            @csrf
            <button type="submit" class="btn-yellow bg-yellow-500 hover:bg-yellow-600 w-full text-center">
                <i class="fas fa-heart"></i> {{ __('messages.add_to_favorite') }}
            </button>
        </form>
    @endif
@endauth
{{-- زر المشاركة --}}
    <button onclick="shareAd('{{ route('ads.show', $ad->slug) }}')" 
            class="btn-yellow bg-yellow-500 hover:bg-yellow-600 w-full text-center">
        <i class="fas fa-share-alt"></i> {{ __('messages.share') }}
    </button>
</div>
{{-- ✅ سكربت المشاركة --}}
<script>
function shareAd(url) {
    if (navigator.share) {
        navigator.share({
            title: document.title,
            text: 'شاهد هذا الإعلان على Delni.co',
            url: url,
        }).catch(err => console.log(err));
    } else {
        navigator.clipboard.writeText(url);
        alert("تم نسخ رابط الإعلان ✅");
    }
}
</script>
    {{-- 🖼️ إعلانات مشابهة --}}
    <div class="mt-12">
<h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">
    <i class="fas fa-search"></i> {{ __('messages.related_ads') }}
</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($relatedAds as $item)
                @php
                    $imgs = is_array($item->images) ? $item->images : json_decode($item->images, true);
                    $img  = !empty($imgs[0]) ? asset('storage/'.$imgs[0]) : asset('storage/placeholder.png');
                @endphp
                    <a href="{{ route('ads.show', $item->slug) }}" class="block bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-lg overflow-hidden">
                    <img src="{{ $img }}" class="w-full h-40 object-cover" alt="related">
                    <div class="p-3">
<h3 class="font-bold truncate text-gray-800 dark:text-gray-100">{{ $item->title }}</h3>
<p class="text-sm text-gray-500 dark:text-gray-300">
    <i class="fas fa-map-marker-alt"></i> {{ $item->city }}
</p>
                        <p class="text-red-600 font-bold text-sm"><i class="fas fa-dollar-sign"></i> {{ number_format($item->price) }} {{ __('messages.currency') }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
{{-- 🌍 مكتبة الأيقونات والخرائط --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    {{-- 🌍 سكربت الخريطة --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
let map;
document.addEventListener("DOMContentLoaded", function () {
    var lat = {{ $ad->lat ?? 41.0672 }};
    var lng = {{ $ad->lng ?? 28.7994 }};
    map = L.map('map').setView([lat, lng], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);
            L.marker([lat, lng]).addTo(map)
                .bindPopup("📍 موقع الإعلان")
                .openPopup();
        });
        function shareAd(url) {
            if (navigator.share) {
                navigator.share({ title: document.title, text: 'شاهد هذا الإعلان على Delni.co', url: url });
            } else {
                navigator.clipboard.writeText(url);
                alert("تم نسخ رابط الإعلان ✅");
            }
        }
    </script>
    {{-- ✅ Lightbox --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
</div>
</x-app-layout>
