{{-- resources/views/ads/partials/related.blade.php --}}
<div class="mt-12">
    <h2 class="text-xl font-bold mb-4"><i class="fas fa-search"></i> {{ __('messages.related_ads') }}</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($relatedAds as $item)
            @php
                $imgs = is_array($item->images) ? $item->images : json_decode($item->images, true);
                $img  = !empty($imgs[0]) ? asset('storage/'.$imgs[0]) : asset('storage/placeholder.png');
            @endphp
            <a href="{{ route('ads.show', $item->id) }}" class="block bg-white rounded-xl shadow hover:shadow-lg overflow-hidden">
                <img src="{{ $img }}" class="w-full h-40 object-cover" />
                <div class="p-3">
                    <h3 class="font-bold truncate">{{ $item->title }}</h3>
                    <p class="text-sm text-gray-500"><i class="fas fa-map-marker-alt"></i> {{ $item->city }}</p>
                    <p class="text-red-600 font-bold text-sm"><i class="fas fa-dollar-sign"></i> {{ number_format($item->price) }} {{ __('messages.currency') }}</p>
                </div>
            </a>
        @endforeach
    </div>
</div>
