{{-- resources/views/mall/products-index.blade.php --}}
<x-app-layout :title="__('mall.products') . ' - ' . $store->name">
    <div class="max-w-7xl mx-auto px-4 py-8 space-y-10">

        {{-- 🧭 Breadcrumb --}}
        <nav class="text-sm text-gray-500 mb-6">
            <a href="{{ route('mall.index') }}" class="hover:underline">🏬 {{ __('mall.mall') }}</a> /
            <a href="{{ route('mall.show', $store->id) }}" class="hover:underline">{{ $store->name }}</a> /
            <span class="text-gray-700 dark:text-gray-300">{{ __('mall.products') }}</span>
        </nav>

        {{-- 🏬 عنوان الصفحة + زر إضافة --}}
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">
                🛒 {{ __('mall.products') }} - {{ $store->name }}
            </h1>
            @auth
                @if(auth()->id() === $store->user_id)
                    <a href="{{ route('mall.products.create', $store->id) }}" class="btn-add">
                        ➕ {{ __('mall.add_product') }}
                    </a>
                @endif
            @endauth
        </div>

        {{-- ✅ شبكة المنتجات --}}
        @if($products->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="card group">
                        {{-- صورة المنتج --}}
                        <a href="{{ route('mall.products.show', [$store->id, $product->id]) }}" class="block relative">
                            <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/no-image.png') }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-48 object-cover rounded-t-lg group-hover:scale-105 transition duration-300">
                            @if($loop->index < 3)
                                <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                    🔥 {{ __('mall.new') }}
                                </span>
                            @endif
                        </a>

                        {{-- بيانات المنتج --}}
                        <div class="p-4 space-y-2">
                            <h2 class="font-bold text-lg text-gray-800 dark:text-white truncate">
                                {{ $product->name }}
                            </h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2">
                                {{ $product->description }}
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="price">{{ $product->price }} {{ __('mall.currency') }}</span>
                                @auth
                                    @if(auth()->id() === $store->user_id)
                                        @include('components.partials.product-actions', ['store' => $store, 'product' => $product])
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- 📄 روابط التصفح --}}
            <div class="mt-10">
                {{ $products->links() }}
            </div>
        @else
            <p class="text-center text-gray-500 dark:text-gray-400">
                <i class="fas fa-info-circle"></i> {{ __('mall.no_products') }}
            </p>
        @endif
    </div>
</x-app-layout>

{{-- ✨ CSS Utility --}}
<style>
.btn-add { @apply px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg shadow text-sm; }
.card { @apply bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-xl transition overflow-hidden; }
.price { @apply text-yellow-600 font-bold; }
</style>
