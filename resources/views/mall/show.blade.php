{{-- resources/views/mall/show.blade.php --}}
<x-app-layout :title="$store->name">
    <div class="max-w-7xl mx-auto px-4 py-10 space-y-10">

        {{-- 🏪 رأس المتجر --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-6 p-6">
                {{-- شعار المتجر --}}
<img src="{{ $store->logo ? asset('storage/'.$store->logo) : asset('storage/placeholder.png') }}"
     class="w-32 h-32 rounded-full border object-cover shadow" alt="Store Logo">

                {{-- بيانات المتجر --}}
                <div class="flex-1 space-y-3">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $store->name }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        {{ $store->description ?? __('mall.no_description_available') }}
                    </p>

                    <div class="flex flex-wrap items-center gap-3">
                        <span class="px-4 py-1 text-sm bg-yellow-100 text-yellow-700 rounded-full">
                            📂 {{ __('mall.' . $store->category) }}
                        </span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            <i class="fas fa-calendar-alt text-yellow-500"></i>
                            {{ __('mall.created_at') }}: {{ $store->created_at->format('Y-m-d') }}
                        </span>
                    </div>
                </div>

{{-- أزرار المالك --}}
@auth
    @if(auth()->id() === $store->user_id)
        <div class="flex flex-col gap-2">

            {{-- ✏️ تعديل المتجر --}}
            <a href="{{ route('mall.edit', $store->id) }}" class="btn-yellow flex items-center gap-2">
                ✏️ {{ __('mall.edit_store') }}
            </a>

            {{-- ➕ إضافة منتج جديد --}}
            <a href="{{ route('mall.products.create', $store->id) }}" class="btn-green flex items-center gap-2">
                ➕ {{ __('mall.add_product') }}
            </a>

            {{-- ⚙️ لوحة تحكم المتجر --}}
            <a href="{{ route('mall.dashboard', $store->id) }}" class="btn-blue flex items-center gap-2">
                ⚙️ {{ __('mall.dashboard') }}
            </a>

            {{-- 🗑️ حذف المتجر --}}
            <form action="{{ route('mall.destroy', $store->id) }}" method="POST" onsubmit="return confirm('{{ __('mall.confirm_delete') }}');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-red flex items-center gap-2">
                    🗑️ {{ __('mall.delete') }}
                </button>
            </form>
        </div>
    @endif
@endauth
            </div>
        </div>

{{-- 📦 منتجات المتجر --}}
<div>
    <h2 class="section-title">📦 {{ __('mall.store_products') }}</h2>

    @if($store->products->count())
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
            @foreach($store->products as $product)

                {{-- ✅ اختيار أول صورة من images --}}
@php
    $images = is_array($product->images)
        ? $product->images
        : json_decode($product->images, true);

    $img = (!empty($images) && isset($images[0]))
        ? asset('storage/' . $images[0])
        : asset('images/no-image.png');
@endphp

                <div class="ad-card group">
                    <a href="{{ route('mall.products.show', [$store->id, $product->id]) }}">
                        <img src="{{ $img }}"
                             alt="{{ $product->name }}"
                             class="w-full h-44 object-cover rounded-lg group-hover:scale-105 transition duration-300">
                    </a>

                    <div class="p-4 space-y-2">
                        <h3 class="font-bold text-lg text-gray-800 dark:text-white truncate">
                            {{ $product->name }}
                        </h3>

                        <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2">
                            {{ $product->description }}
                        </p>

                        <span class="price text-yellow-500 font-bold text-lg">
                            {{ number_format($product->price) }} {{ __('mall.currency') }}
                        </span>

                        <a href="{{ route('mall.products.show', [$store->id, $product->id]) }}"
                           class="btn-yellow mt-2 w-full block text-center">
                            👁️ {{ __('mall.view') }}
                        </a>
                    </div>
                </div>

            @endforeach
        </div>
    @else
        <p class="text-gray-500 dark:text-gray-400">{{ __('mall.no_products') }}</p>
    @endif
</div>

        {{-- 📢 إعلانات المتجر --}}
        <div>
            <h2 class="section-title">📢 {{ __('mall.ads') }}</h2>

            @if($store->ads->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($store->ads as $ad)
                        <div class="ad-card group relative">
                            @if($ad->is_featured)
                                <span class="badge-featured">⭐ {{ __('mall.featured') }}</span>
                            @endif
                            <a href="{{ route('mall.ads.show', [$store->id, $ad->id]) }}">
                                <img src="{{ !empty($ad->images) && is_array($ad->images) && isset($ad->images[0]) 
                                    ? asset('storage/'.$ad->images[0]) 
                                    : asset('images/no-image.png') }}"
                                     alt="{{ $ad->title }}"
                                     class="w-full h-40 object-cover rounded-t-xl group-hover:opacity-90 transition">
                            </a>
                            <div class="p-4 space-y-2">
                                <h3 class="font-bold text-lg text-gray-800 dark:text-white truncate">
                                    {{ $ad->title }}
                                </h3>
                                <span class="price">{{ $ad->price }} {{ __('mall.currency') }}</span>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    🌍 {{ $ad->city }} | 📂 {{ __('mall.' . $ad->category) }}
                                </p>
                                <a href="{{ route('mall.ads.show', [$store->id, $ad->id]) }}"
                                   class="btn-yellow mt-2">
                                    👁️ {{ __('mall.view') }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400">{{ __('mall.no_ads') }}</p>
            @endif
        </div>
    </div>
</x-app-layout>

