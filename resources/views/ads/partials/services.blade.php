{{-- resources/views/ads/partials/services.blade.php --}}
<div class="bg-white rounded-xl shadow p-6">
    <h2 class="text-lg font-bold mb-4"><i class="fas fa-tools"></i> {{ __('messages.service_details') }}</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
        <p><i class="fas fa-wrench text-gray-500"></i> {{ __('messages.service_type') }}: {{ $ad->service_type ?? '-' }}</p>
        <p><i class="fas fa-user-tie text-gray-500"></i> {{ __('messages.provider_name') }}: {{ $ad->provider_name ?? '-' }}</p>
    </div>
</div>
