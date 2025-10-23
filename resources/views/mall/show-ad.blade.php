{{-- resources/views/mall/show-ad.blade.php --}}
<x-app-layout :title="$ad->title">
    <div class="max-w-5xl mx-auto px-4 py-10 space-y-8">

        {{-- 🏪 معلومات المتجر --}}
        <div class="flex items-center gap-4 mb-6">
            <img src="{{ $store->logo ? asset('storage/'.$store->logo) : asset('storage/placeholder.png') }}"
                 class="w-14 h-14 rounded-full border border-gray-200 dark:border-gray-700 object-cover"
                 alt="{{ $store->name }}">
            <div>
                <a href="{{ route('mall.show', $store->id) }}" class="text-lg font-bold text-gray-800 dark:text-gray-200 hover:text-yellow-500">
                    {{ $store->name }}
                </a>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    <i class="fas fa-tags text-yellow-500"></i> {{ __('mall.' . $store->category) }}
                </p>
            </div>
        </div>

        {{-- 📢 تفاصيل الإعلان --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            @if($ad->images && is_array($ad->images))
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4">
                    @foreach($ad->images as $img)
                        <img src="{{ asset('storage/'.$img) }}" class="rounded-lg object-cover w-full h-60">
                    @endforeach
                </div>
            @endif

            <div class="p-6 space-y-4">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $ad->title }}
                </h1>
                <p class="text-gray-600 dark:text-gray-300">
                    {{ $ad->description ?? __('mall.no_description_available') }}
                </p>
                <p class="text-xl font-bold text-yellow-600">
                    {{ $ad->price }} {{ __('mall.currency') }}
                </p>
                <p class="text-gray-500 dark:text-gray-400">
                    <i class="fas fa-map-marker-alt text-yellow-500"></i> {{ $ad->city }}
                </p>
            </div>
        </div>

        {{-- ✅ الأكشنز للمالك --}}
        @auth
            @if(auth()->id() === $store->user_id)
                @include('components.partials.ad-actions', ['store' => $store, 'ad' => $ad])
            @endif
        @endauth
    </div>
</x-app-layout>
