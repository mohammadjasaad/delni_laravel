{{-- resources/views/mall/ads-index.blade.php --}}
<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-10">

        {{-- 🧭 Breadcrumb --}}
        <nav class="text-sm text-gray-500 mb-6">
            <a href="{{ route('mall.index') }}" class="hover:underline">🏬 {{ __('mall.mall') }}</a> /
            <a href="{{ route('mall.show', $store->id) }}" class="hover:underline">{{ $store->name }}</a> /
            <span class="text-gray-700 dark:text-gray-300">{{ __('mall.my_ads') }}</span>
        </nav>

        {{-- 🏬 عنوان الصفحة --}}
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">
                📢 {{ __('mall.my_ads') }} - {{ $store->name }}
            </h1>
            <a href="{{ route('mall.dashboard', $store->id) }}" 
               class="px-4 py-2 rounded bg-gray-200 dark:bg-gray-700 text-gray-800 
                      dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                ⬅️ {{ __('mall.back') }}
            </a>
        </div>

        {{-- 🔄 شبكة الإعلانات --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse ($ads as $ad)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-lg transition p-4 flex flex-col">
                    {{-- صورة الإعلان --}}
                    <a href="{{ route('mall.ads.show', [$store->id, $ad->id]) }}">
                        <img src="{{ !empty($ad->images) && is_array($ad->images) && isset($ad->images[0]) ? asset('storage/'.$ad->images[0]) : asset('images/no-image.png') }}"
                             alt="{{ $ad->title }}"
                             class="w-full h-40 object-cover rounded-lg mb-4">
                    </a>

                    {{-- عنوان --}}
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-1">{{ $ad->title }}</h3>

                    {{-- السعر --}}
                    <span class="font-bold text-yellow-600 mb-2">
                        {{ $ad->price }} {{ __('mall.currency') }}
                    </span>

                    {{-- المدينة + التصنيف --}}
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                        🌍 {{ $ad->city }} | 📂 {{ __('mall.' . $ad->category) }}
                    </p>

                    {{-- نوع الإعلان --}}
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">
                        {{ $ad->type === 'request' ? __('mall.request') : __('mall.offer') }}
                        @if($ad->is_featured) ⭐ {{ __('mall.featured') }} @endif
                        @if($ad->is_urgent) 🔥 {{ __('mall.urgent') }} @endif
                    </p>

                    {{-- ✅ الأكشنز --}}
                    <div class="flex items-center justify-between mt-auto">
                        <a href="{{ route('mall.ads.show', [$store->id, $ad->id]) }}"
                           class="text-sm px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded">
                            👁️ {{ __('mall.view') }}
                        </a>
                        @auth
                            @include('components.partials.ad-actions', ['store' => $store, 'ad' => $ad])
                        @endauth
                    </div>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400">{{ __('mall.no_ads') }}</p>
            @endforelse
        </div>

        {{-- 📌 Pagination --}}
        <div class="mt-8">
            {{ $ads->links() }}
        </div>

    </div>
</x-app-layout>
