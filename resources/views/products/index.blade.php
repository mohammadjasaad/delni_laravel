{{-- resources/views/products/index.blade.php --}}
<x-app-layout :title="__('mall.products')">
    <div class="max-w-7xl mx-auto px-4 py-10 space-y-10">

        {{-- 🎯 العنوان --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                🛒 {{ __('mall.products') }}
            </h1>
            <a href="{{ route('mall.products.create', $store->id) }}"
               class="btn-primary flex items-center gap-2">
                ➕ {{ __('mall.add_product') }}
            </a>
        </div>

        {{-- 📦 شبكة المنتجات --}}
        @if($products->count())
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach($products as $product)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-xl transition overflow-hidden group">
                        <a href="{{ route('mall.products.show', [$store->id, $product->id]) }}" class="block relative">
                            <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/no-image.png') }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-52 object-cover group-hover:scale-105 transition duration-300">
                        </a>
                        <div class="p-3 space-y-2">
                            <h2 class="font-semibold text-gray-800 dark:text-gray-100 truncate">
                                {{ $product->name }}
                            </h2>
                            <span class="font-bold text-yellow-600 text-lg">
                                {{ $product->price }} {{ __('mall.currency') }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- 📄 روابط التصفح --}}
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <p class="text-center text-gray-500 dark:text-gray-400">
                {{ __('mall.no_products') }}
            </p>
        @endif

    </div>
</x-app-layout>
