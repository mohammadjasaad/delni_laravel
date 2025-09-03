{{-- resources/views/ads/partials/cars.blade.php --}}
<div class="bg-white rounded-xl shadow p-6">
    <h2 class="text-lg font-bold mb-4"><i class="fas fa-car"></i> {{ __('messages.car_details') }}</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
        <p><i class="fas fa-car-side text-gray-500"></i> {{ __('messages.car_model') }}: {{ $ad->car_model ?? '-' }}</p>
        <p><i class="fas fa-calendar-alt text-gray-500"></i> {{ __('messages.car_year') }}: {{ $ad->car_year ?? '-' }}</p>
        <p><i class="fas fa-tachometer-alt text-gray-500"></i> {{ __('messages.car_km') }}: {{ $ad->car_km ?? '-' }} كم</p>
        <p><i class="fas fa-gas-pump text-gray-500"></i> {{ __('messages.fuel') }}: {{ $ad->fuel ?? '-' }}</p>
        <p><i class="fas fa-cogs text-gray-500"></i> {{ __('messages.gearbox') }}: {{ $ad->gearbox ?? '-' }}</p>
        <p><i class="fas fa-palette text-gray-500"></i> {{ __('messages.color') }}: {{ $ad->car_color ?? '-' }}</p>
        <p><i class="fas fa-check-circle text-gray-500"></i> {{ __('messages.condition') }}: {{ $ad->is_new ? __('messages.new') : __('messages.used') }}</p>
    </div>
</div>
