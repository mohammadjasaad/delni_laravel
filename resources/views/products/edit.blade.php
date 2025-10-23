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

                {{-- 🖼️ صورة --}}
                <div>
                    <x-label for="image" :value="__('mall.product_image')" />
                    <input id="image" type="file" name="image" class="file-input">

                    {{-- ✅ الصورة الحالية --}}
                    @if($product->image)
                        <div class="mt-3">
                            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-28 h-28 rounded object-cover border">
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
