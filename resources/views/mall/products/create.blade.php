{{-- resources/views/mall/products/create.blade.php --}}
<x-app-layout :title="__('mall.add_product')">
    <div class="max-w-4xl mx-auto px-4 py-10">

        {{-- 🧭 العنوان --}}
        <h1 class="text-3xl font-bold text-center mb-8 text-gray-800 dark:text-gray-100">
            ➕ {{ __('mall.add_product') }} - {{ $store->name }}
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

        {{-- 📝 نموذج إضافة منتج --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 space-y-6">
            <form action="{{ route('mall.products.store', $store->id) }}" 
                  method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- 🏷️ اسم المنتج --}}
                <div>
                    <x-label for="name" :value="__('mall.product_name')" />
                    <x-input id="name" type="text" name="name" class="w-full" 
                             value="{{ old('name') }}" required autofocus />
                </div>

                {{-- 📝 الوصف --}}
                <div>
                    <x-label for="description" :value="__('mall.product_description')" />
                    <textarea id="description" name="description" rows="4"
                              class="textarea-input">{{ old('description') }}</textarea>
                </div>

                {{-- 💰 السعر --}}
                <div>
                    <x-label for="price" :value="__('mall.product_price')" />
                    <x-input id="price" type="number" step="0.01" name="price" 
                             value="{{ old('price') }}" required />
                </div>

                {{-- 🖼️ صورة المنتج --}}
                <div>
                    <x-label for="image" :value="__('mall.product_image')" />
                    <input type="file" id="image" name="image" class="file-input" accept="image/*" required />
                </div>

                {{-- 🎯 الأزرار --}}
                <div class="flex items-center justify-between">
                    <a href="{{ route('mall.dashboard', $store->id) }}" class="btn-secondary">
                        ⬅️ {{ __('mall.back') }}
                    </a>
                    <button type="submit" class="btn-primary">
                        💾 {{ __('mall.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

{{-- ✨ CSS Utility --}}
<style>
.btn-primary { @apply px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg shadow transition; }
.btn-secondary { @apply px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition; }
.alert-success { @apply bg-green-100 text-green-800 px-4 py-2 rounded-lg mb-4; }
.alert-error { @apply bg-red-100 text-red-700 px-4 py-2 rounded-lg mb-4; }
</style>
