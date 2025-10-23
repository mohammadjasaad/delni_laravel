{{-- resources/views/mall/edit-product.blade.php --}}
<x-app-layout :title="__('mall.edit_product')">
    <div class="max-w-4xl mx-auto px-4 py-10">

        {{-- 🧭 العنوان --}}
        <h1 class="text-3xl font-bold text-center mb-8 text-gray-800 dark:text-gray-100">
            ✏️ {{ __('mall.edit_product') }} - {{ $store->name }}
        </h1>

        {{-- ✅ رسالة نجاح --}}
        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        {{-- ❌ عرض الأخطاء --}}
        @if ($errors->any())
            <div class="alert-error">
                <ul class="list-disc pl-6 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>⚠️ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- 📝 النموذج --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 space-y-6">
            <form action="{{ route('mall.products.update', [$store->id, $product->id]) }}" 
                  method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- 🏷️ اسم المنتج --}}
                <div>
                    <x-label for="name" :value="__('mall.product_name')" />
                    <x-input id="name" type="text" name="name" class="w-full" 
                             value="{{ old('name', $product->name) }}" required autofocus />
                </div>

                {{-- 📝 الوصف --}}
                <div>
                    <x-label for="description" :value="__('mall.product_description')" />
                    <textarea id="description" name="description" rows="4"
                              class="textarea-input">{{ old('description', $product->description) }}</textarea>
                </div>

                {{-- 💰 السعر --}}
                <div>
                    <x-label for="price" :value="__('mall.product_price')" />
                    <x-input id="price" type="number" step="0.01" name="price" 
                             value="{{ old('price', $product->price) }}" required />
                </div>

                {{-- 🖼️ صورة المنتج --}}
                <div>
                    <x-label for="image" :value="__('mall.product_image')" />
                    @if($product->image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/'.$product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-32 h-32 object-cover rounded border shadow">
                        </div>
                    @endif
                    <input type="file" id="image" name="image" class="file-input" />
                </div>

                {{-- 🎯 الأزرار --}}
                <div class="flex items-center justify-between">
                    <a href="{{ route('mall.dashboard', $store->id) }}" class="btn-secondary">
                        ⬅️ {{ __('mall.back') }}
                    </a>
                    <button type="submit" class="btn-primary">
                        💾 {{ __('mall.save_changes') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
