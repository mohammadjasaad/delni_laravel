{{-- resources/views/products/edit.blade.php --}}
<x-app-layout :title="__('mall.edit_product') . ' - ' . $product->name">
    <div class="max-w-4xl mx-auto px-4 py-10">

        {{-- 🎯 العنوان --}}
        <h1 class="text-3xl font-bold text-center mb-6 text-gray-800 dark:text-gray-100">
            ✏️ {{ __('mall.edit_product') }} - {{ $product->name }}
        </h1>

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
        <div class="card p-6">
            <form action="{{ route('mall.products.update', [$store->id, $product->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- 🏷️ الاسم --}}
                <div>
                    <x-label for="name" :value="__('mall.product_name')" />
                    <x-input id="name" type="text" name="name" value="{{ old('name', $product->name) }}" required />
                </div>

                {{-- 📝 الوصف --}}
                <div>
                    <x-label for="description" :value="__('mall.product_description')" />
                    <textarea id="description" name="description" rows="4" class="textarea-input">{{ old('description', $product->description) }}</textarea>
                </div>

                {{-- 💰 السعر --}}
                <div>
                    <x-label for="price" :value="__('mall.product_price')" />
                    <x-input id="price" type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required />
                </div>

{{-- 🖼️ الصور (متعددة) --}}
<div>
    <x-label for="images" :value="__('mall.product_images')" />
    <input id="images" type="file" name="images[]" class="file-input" multiple>

    {{-- ✅ عرض الصور الحالية --}}
    @if($product->images && is_array($product->images))
        <div class="flex flex-wrap gap-3 mt-3">
            @foreach($product->images as $img)
                <img src="{{ asset('storage/'.$img) }}" class="w-24 h-24 rounded object-cover border">
            @endforeach
        </div>
    @endif
</div>

                {{-- 🎯 الأزرار --}}
                <div class="flex items-center justify-between">
                    <a href="{{ route('mall.show', $store->id) }}" class="btn-secondary">
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
