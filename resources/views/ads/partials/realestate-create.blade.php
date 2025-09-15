{{-- 🏠 تفاصيل العقارات --}}
<div class="space-y-4">
    <h2 class="section-title">🏠 {{ __('messages.real_estate_details') }}</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <x-input type="text" name="neighborhood" label="📍 {{ __('messages.neighborhood') }}" value="{{ old('neighborhood') }}" required />
        <x-input type="number" name="floor" label="🏢 {{ __('messages.floor') }} ({{ __('messages.optional') }})" value="{{ old('floor') }}" />
        <x-input type="number" name="area_total" label="📐 {{ __('messages.area_total') }}" value="{{ old('area_total') }}" required />
        <x-input type="number" name="area_net" label="📏 {{ __('messages.area_net') }} ({{ __('messages.optional') }})" value="{{ old('area_net') }}" />
        <x-input type="number" name="rooms" label="🚪 {{ __('messages.rooms') }}" value="{{ old('rooms') }}" required />
        <x-input type="number" name="bathrooms" label="🚿 {{ __('messages.bathrooms') }} ({{ __('messages.optional') }})" value="{{ old('bathrooms') }}" />
        <x-input type="number" name="building_age" label="🏗️ {{ __('messages.building_age') }} ({{ __('messages.optional') }})" value="{{ old('building_age') }}" />
        <x-input type="text" name="heating_type" label="🔥 {{ __('messages.heating') }} ({{ __('messages.optional') }})" value="{{ old('heating_type') }}" />
    </div>

    {{-- ⬆️ مصعد --}}
    <label><input type="checkbox" name="has_elevator" {{ old('has_elevator') ? 'checked' : '' }}> ⬆️ {{ __('messages.elevator') }} ({{ __('messages.optional') }})</label>

    {{-- 🚗 موقف سيارات --}}
    <label><input type="checkbox" name="has_parking" {{ old('has_parking') ? 'checked' : '' }}> 🚗 {{ __('messages.parking') }} ({{ __('messages.optional') }})</label>

    {{-- 🌍 الموقع --}}
    <x-label :value="__('messages.location')" />
    <input type="hidden" name="lat" id="realestate_lat" value="{{ old('lat') }}">
    <input type="hidden" name="lng" id="realestate_lng" value="{{ old('lng') }}">
    <div id="realestate_map" class="h-64 w-full rounded-lg border mb-2"></div>
    <button type="button" id="realestate_locateBtn" class="btn-blue w-full">📍 تحديد موقعي الحالي</button>

    {{-- 🖼️ صور العقار --}}
    <x-label for="images" :value="__('messages.images')" />
    <input type="file" name="images[]" id="realestate_images" multiple>
    <div id="realestate_preview" class="flex flex-wrap gap-2 mt-2"></div>
</div>
