{{-- resources/views/products/show.blade.php --}}
<x-app-layout :title="$product->name">
    <div class="max-w-5xl mx-auto px-4 py-10 space-y-10">

        {{-- 🏪 بطاقة المنتج --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <div class="grid md:grid-cols-2 gap-6">
                {{-- 🖼️ الصورة --}}
                <div>
                    <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/no-image.png') }}"
                         alt="{{ $product->name }}"
                         class="w-full h-96 object-cover rounded-lg shadow">
                </div>

                {{-- 📄 التفاصيل --}}
                <div class="p-6 flex flex-col space-y-4">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $product->name }}</h1>
                    <p class="text-gray-600 dark:text-gray-300">{{ $product->description }}</p>
                    <span class="text-2xl font-bold text-yellow-600">{{ $product->price }} {{ __('mall.currency') }}</span>

                    <div class="flex gap-3 mt-4">
                        <a href="{{ route('mall.show', $store->id) }}" class="btn-secondary">
                            ⬅️ {{ __('mall.back') }}
                        </a>

                        @auth
                            @if(auth()->id() === $store->user_id)
                                <a href="{{ route('mall.products.edit', [$store->id, $product->id]) }}" class="btn-primary">
                                    ✏️ {{ __('mall.edit_product') }}
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
