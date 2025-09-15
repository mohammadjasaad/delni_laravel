{{-- 🚗 تفاصيل السيارات --}}
<div class="space-y-4">
    <h2 class="section-title">🚗 {{ __('messages.car_details') }}</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <x-input type="text" name="brand" label="🏷️ {{ __('messages.car_brand') }}" value="{{ old('brand') }}" required />
        <x-input type="text" name="model" label="📌 {{ __('messages.car_model') }}" value="{{ old('model') }}" required />
        <x-input type="number" name="year" label="📅 {{ __('messages.year') }} ({{ __('messages.optional') }})" value="{{ old('year') }}" />
        <x-input type="text" name="fuel" label="⛽ {{ __('messages.fuel') }}" value="{{ old('fuel') }}" required />
        <x-input type="text" name="transmission" label="⚙️ {{ __('messages.transmission') }}" value="{{ old('transmission') }}" required />
        <x-input type="text" name="color" label="🎨 {{ __('messages.color') }} ({{ __('messages.optional') }})" value="{{ old('color') }}" />
        <x-input type="text" name="condition" label="✅ {{ __('messages.condition') }}" value="{{ old('condition') }}" required />
        <x-input type="number" name="engine_power" label="🚀 {{ __('messages.engine_power') }} ({{ __('messages.optional') }})" value="{{ old('engine_power') }}" />
        <x-input type="number" name="engine_size" label="⚡ {{ __('messages.engine_size') }} ({{ __('messages.optional') }})" value="{{ old('engine_size') }}" />
        <x-input type="text" name="warranty" label="🛡️ {{ __('messages.warranty') }} ({{ __('messages.optional') }})" value="{{ old('warranty') }}" />
        <x-input type="text" name="drive_type" label="🛞 {{ __('messages.drive_type') }} ({{ __('messages.optional') }})" value="{{ old('drive_type') }}" />
        <x-input type="number" name="mileage" label="📏 {{ __('messages.mileage') }} ({{ __('messages.optional') }})" value="{{ old('mileage') }}" />
    </div>

    {{-- 🌍 الموقع --}}
    <x-label :value="__('messages.location')" />
    <input type="hidden" name="lat" id="car_lat" value="{{ old('lat') }}">
    <input type="hidden" name="lng" id="car_lng" value="{{ old('lng') }}">
    <div id="car_map" class="h-64 w-full rounded-lg border mb-2"></div>
    <button type="button" id="car_locateBtn" class="btn-blue w-full">📍 تحديد موقعي الحالي</button>

    {{-- 🖼️ صور السيارة --}}
    <x-label for="images" :value="__('messages.images')" />
    <input type="file" name="images[]" id="car_images" multiple>
    <div id="car_preview" class="flex flex-wrap gap-2 mt-2"></div>
</div>
