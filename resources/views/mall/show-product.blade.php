{{-- resources/views/mall/show-product.blade.php --}}
<x-app-layout :title="$product->name">
    <div class="max-w-6xl mx-auto px-4 py-10 space-y-10">

        {{-- 🧭 Breadcrumb --}}
        <nav class="text-sm text-gray-500 mb-6">
            <a href="{{ route('mall.index') }}" class="hover:underline">🏬 {{ __('mall.mall') }}</a> /
            <a href="{{ route('mall.show', $store->id) }}" class="hover:underline">{{ $store->name }}</a> /
            <span class="text-gray-700 dark:text-gray-300">{{ $product->name }}</span>
        </nav>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

            {{-- 📸 صورة المنتج --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" 
                         alt="{{ $product->name }}"
                         class="w-full h-[420px] object-cover">
                @else
                    <img src="{{ asset('images/no-image.png') }}" 
                         class="w-full h-[420px] object-cover">
                @endif
            </div>

            {{-- ℹ️ تفاصيل المنتج --}}
            <div class="flex flex-col space-y-6">
                {{-- 🏷️ اسم المنتج --}}
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    {{ $product->name }}
                </h1>

                {{-- 📝 الوصف --}}
                <p class="text-gray-600 dark:text-gray-300 text-lg leading-relaxed">
                    {{ $product->description ?? __('mall.no_description_available') }}
                </p>

                {{-- 💰 السعر --}}
                <div class="text-2xl font-bold text-yellow-600">
                    {{ $product->price }} {{ __('mall.currency') }}
                </div>

                {{-- 🏪 معلومات المتجر --}}
                <div class="flex items-center gap-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <img src="{{ $store->logo ? asset('storage/'.$store->logo) : asset('images/no-image.png') }}"
                         alt="{{ $store->name }}"
                         class="w-14 h-14 rounded-full border object-cover">
                    <div>
                        <a href="{{ route('mall.show', $store->id) }}" 
                           class="font-semibold text-lg text-gray-800 dark:text-gray-200 hover:text-yellow-500">
                            {{ $store->name }}
                        </a>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            📂 {{ __('mall.' . $store->category) }}
                        </p>
                    </div>
                </div>

                {{-- 🛠️ أكشنز للمالك --}}
                @auth
                    @if(auth()->id() === $store->user_id)
                        <div>
                            @include('components.partials.product-actions', ['store' => $store, 'product' => $product])
                        </div>
                    @endif
                @endauth

                {{-- 📅 تاريخ الإضافة --}}
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ __('mall.created_at') }}: {{ $product->created_at->format('Y-m-d') }}
                </p>

                {{-- 🎯 أزرار --}}
                <div class="flex items-center gap-4">
                    <a href="{{ route('mall.products.index', $store->id) }}" class="btn-secondary">
                        ⬅️ {{ __('mall.back') }}
                    </a>
                    <a href="{{ route('mall.products.index', $store->id) }}" 
                       class="btn-primary">
                        🛒 {{ __('mall.shop_more') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- ✨ CSS Utility --}}
<style>
.btn-primary { @apply px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg shadow transition; }
.btn-secondary { @apply px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition; }
</style>
