{{-- 🛠️ تفاصيل الخدمات --}}
<div class="space-y-4">
    <h2 class="section-title">🛠️ {{ __('messages.service_details') }}</h2>


    <x-input type="text" name="provider_name" label="👤 {{ __('messages.provider_name') }}" value="{{ old('provider_name') }}" />
    <x-input type="text" name="phone" label="📞 {{ __('messages.phone') }}" value="{{ old('phone') }}" />
    <x-textarea name="service_description" label="📝 {{ __('messages.service_description') }}" rows="3">{{ old('service_description') }}</x-textarea>

    {{-- 🌍 الموقع --}}
    <x-label :value="__('messages.location')" />
    <input type="hidden" name="lat" id="service_lat" value="{{ old('lat') }}">
    <input type="hidden" name="lng" id="service_lng" value="{{ old('lng') }}">
    <div id="service_map" class="h-64 w-full rounded-lg border mb-2"></div>
    <button type="button" id="service_locateBtn" class="btn-blue w-full">📍 تحديد موقعي الحالي</button>

    {{-- 🖼️ صور الخدمة --}}
    <x-label for="images" :value="__('messages.images')" />
    <input type="file" name="images[]" id="service_images" multiple>
    <div id="service_preview" class="flex flex-wrap gap-2 mt-2"></div>
</div>
