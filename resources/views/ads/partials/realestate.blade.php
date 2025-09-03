{{-- resources/views/ads/partials/realestate.blade.php --}}
<div class="bg-white rounded-xl shadow p-6">
    <h2 class="text-lg font-bold mb-4"><i class="fas fa-home"></i> {{ __('messages.real_estate_details') }}</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
        <p><i class="fas fa-tag text-gray-500"></i> {{ __('messages.subcategory') }}: {{ $ad->subcategory ?? '-' }}</p>
        <p><i class="fas fa-bed text-gray-500"></i> {{ __('messages.rooms') }}: {{ $ad->rooms ?? '-' }}</p>
        <p><i class="fas fa-bath text-gray-500"></i> {{ __('messages.bathrooms') }}: {{ $ad->bathrooms ?? '-' }}</p>
        <p><i class="fas fa-ruler-combined text-gray-500"></i> {{ __('messages.area') }}: {{ $ad->area ?? '-' }} م²</p>
        <p><i class="fas fa-building text-gray-500"></i> {{ __('messages.floor') }}: {{ $ad->floor ?? '-' }}</p>
        <p><i class="fas fa-industry text-gray-500"></i> {{ __('messages.building_age') }}: {{ $ad->building_age ?? '-' }}</p>
        <p><i class="fas fa-elevator text-gray-500"></i> {{ __('messages.elevator') }}: {{ $ad->has_elevator ? __('messages.yes') : __('messages.no') }}</p>
        <p><i class="fas fa-parking text-gray-500"></i> {{ __('messages.parking') }}: {{ $ad->has_parking ? __('messages.yes') : __('messages.no') }}</p>
        <p><i class="fas fa-fire text-gray-500"></i> {{ __('messages.heating') }}: {{ $ad->heating_type ?? '-' }}</p>
    </div>
</div>
