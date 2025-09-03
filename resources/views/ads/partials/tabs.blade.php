{{-- resources/views/ads/partials/tabs.blade.php --}}
<div x-data="{ tab: 'details' }" class="mt-4">
    <div class="flex gap-6 border-b mb-4">
        <button @click="tab='details'" :class="tab==='details' ? 'border-b-2 border-yellow-500 font-bold text-yellow-600' : ''" class="pb-2 flex items-center gap-1">
            <i class="fas fa-info-circle"></i> {{ __('messages.details') }}
        </button>
        <button @click="tab='description'" :class="tab==='description' ? 'border-b-2 border-yellow-500 font-bold text-yellow-600' : ''" class="pb-2 flex items-center gap-1">
            <i class="fas fa-align-left"></i> {{ __('messages.description') }}
        </button>
        <button @click="tab='map'" :class="tab==='map' ? 'border-b-2 border-yellow-500 font-bold text-yellow-600' : ''" class="pb-2 flex items-center gap-1">
            <i class="fas fa-map"></i> {{ __('messages.location') }}
        </button>
    </div>

    {{-- 📑 تفاصيل --}}
    <div x-show="tab==='details'" class="space-y-4">
        @includeWhen($ad->category === 'realestate' || $ad->category === 'عقارات', 'ads.partials.realestate')
        @includeWhen($ad->category === 'cars' || $ad->category === 'سيارات', 'ads.partials.cars')
        @includeWhen($ad->category === 'services' || $ad->category === 'خدمات', 'ads.partials.services')
    </div>

    {{-- 📝 وصف --}}
    <div x-show="tab==='description'" class="text-gray-700 leading-relaxed">
        {{ $ad->description }}
    </div>

    {{-- 🗺️ خريطة --}}
    <div x-show="tab==='map'" class="mt-4">
        <div id="map" class="w-full h-64 rounded-lg shadow"></div>
    </div>
</div>
