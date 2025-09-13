{{-- resources/views/ads/partials/list.blade.php --}}
@forelse($ads as $ad)
    @php
        $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
        $firstImage = !empty($images[0]) ? asset('storage/'.$images[0]) : asset('storage/placeholder.png');
    @endphp

    <div class="ad-card relative {{ $ad->is_featured ? 'border-yellow-400':'border-gray-200 dark:border-gray-700' }}">
        {{-- ⭐ إعلان مميز --}}
        @if($ad->is_featured)
            <span class="badge-featured"><i class="fas fa-star"></i></span>
        @endif

        {{-- ❤️ زر المفضلة --}}
        <div class="absolute top-2 left-2 z-10">
            @auth
                @if(auth()->user()->favorites->contains($ad->id))
                    <form action="{{ route('ads.unfavorite', $ad->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-gray-400 transition">
                            <i class="fas fa-heart fa-lg"></i>
                        </button>
                    </form>
                @else
                    <form action="{{ route('ads.favorite', $ad->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-600 transition">
                            <i class="far fa-heart fa-lg"></i>
                        </button>
                    </form>
                @endif
            @endauth
        </div>

        {{-- صورة الإعلان --}}
        <a href="{{ route('ads.show', $ad->slug) }}">
            <img src="{{ $firstImage }}" class="w-full h-48 object-cover rounded-t-xl" alt="ad">
        </a>

        {{-- تفاصيل الإعلان --}}
        <div class="p-4 flex flex-col justify-between flex-1">
            <h2 class="font-bold text-base truncate text-gray-900 dark:text-white">{{ $ad->title }}</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm">
                <i class="fas fa-map-marker-alt text-red-500"></i> {{ $ad->city }}
            </p>
            <p class="text-red-600 font-bold text-sm mt-1">
                <i class="fas fa-dollar-sign"></i> {{ number_format($ad->price) }} {{ __('messages.currency') }}
            </p>
            <a href="{{ route('ads.show', $ad->slug) }}" class="block mt-3 text-center btn-yellow">
                <i class="fas fa-eye"></i> {{ __('messages.view_ad') }}
            </a>
        </div>
    </div>
@empty
    <p class="text-center col-span-4 text-gray-500 mt-8">
        <i class="fas fa-exclamation-circle"></i> {{ __('messages.no_ads_found') }}
    </p>
@endforelse
