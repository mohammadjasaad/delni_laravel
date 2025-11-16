{{-- resources/views/mall/create.blade.php --}}
<x-app-layout title="➕ {{ __('mall.add_store') }}">
    <div class="max-w-4xl mx-auto px-4 py-10">

        {{-- 🧭 العنوان --}}
        <h1 class="text-3xl font-bold text-center mb-8 text-gray-800 dark:text-gray-100">
            🏬 {{ __('mall.add_store') }}
        </h1>

        {{-- ✅ رسالة نجاح --}}
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
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
        <div class="card p-6">
            <form action="{{ route('mall.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- 🏷️ اسم المتجر --}}
                <div>
                    <x-label for="name" :value="__('mall.store_name')" />
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                             value="{{ old('name') }}" required autofocus />
                </div>

{{-- 📂 التصنيف --}}
<div>
    <x-label for="category" :value="__('mall.category')" />

    @php
        $categories = config('mall.categories');
    @endphp

    <select id="category" name="category" class="select-input" required>
        @foreach($categories as $key => $label)
            <option value="{{ $key }}">{{ $label }}</option>
        @endforeach
    </select>
</div>

                {{-- 📝 الوصف --}}
                <div>
                    <x-label for="description" :value="__('mall.description')" />
                    <textarea id="description" name="description" rows="4" class="textarea-input">{{ old('description') }}</textarea>
                </div>

{{-- 🖼️ شعار المتجر --}}
<div>
    <x-label for="logo" :value="__('mall.store_logo')" />
    <input type="file" name="logo" id="logo" accept="image/*"
           class="block mt-1 w-full border border-gray-300 rounded-lg p-2" required>
</div>
                {{-- 🎯 الأزرار --}}
                <div class="flex items-center justify-between">
                    <a href="{{ route('mall.index') }}" class="btn-secondary">
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
