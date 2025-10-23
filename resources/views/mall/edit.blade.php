{{-- resources/views/mall/edit.blade.php --}}
<x-app-layout title="✏️ {{ __('mall.edit_store') }}">
    <div class="max-w-4xl mx-auto px-4 py-10">

        {{-- 🧭 العنوان --}}
        <h1 class="text-3xl font-bold text-center mb-8 text-gray-800 dark:text-gray-100">
            🏬 {{ __('mall.edit_store') }} - {{ $store->name }}
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
            <form action="{{ route('mall.update', $store->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- 🏷️ اسم المتجر --}}
                <div>
                    <x-label for="name" :value="__('mall.store_name')" />
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                             value="{{ old('name', $store->name) }}" required autofocus />
                </div>

                {{-- 📂 التصنيف --}}
                <div>
                    <x-label for="category" :value="__('mall.category')" />
                    <select id="category" name="category" class="select-input" required>
                        <option value="electronics" {{ old('category', $store->category) == 'electronics' ? 'selected' : '' }}>
                            {{ __('mall.electronics') }}
                        </option>
                        <option value="cars" {{ old('category', $store->category) == 'cars' ? 'selected' : '' }}>
                            {{ __('mall.cars') }}
                        </option>
                        <option value="clothes" {{ old('category', $store->category) == 'clothes' ? 'selected' : '' }}>
                            {{ __('mall.clothes') }}
                        </option>
                        <option value="realestate" {{ old('category', $store->category) == 'realestate' ? 'selected' : '' }}>
                            {{ __('mall.realestate') }}
                        </option>
                        <option value="books" {{ old('category', $store->category) == 'books' ? 'selected' : '' }}>
                            {{ __('mall.books') }}
                        </option>
                        <option value="services" {{ old('category', $store->category) == 'services' ? 'selected' : '' }}>
                            {{ __('mall.services') }}
                        </option>
                        <option value="furniture" {{ old('category', $store->category) == 'furniture' ? 'selected' : '' }}>
                            {{ __('mall.furniture') }}
                        </option>
                        <option value="food" {{ old('category', $store->category) == 'food' ? 'selected' : '' }}>
                            {{ __('mall.food') }}
                        </option>
                        <option value="others" {{ old('category', $store->category) == 'others' ? 'selected' : '' }}>
                            {{ __('mall.others') }}
                        </option>
                    </select>
                </div>

                {{-- 📝 الوصف --}}
                <div>
                    <x-label for="description" :value="__('mall.description')" />
                    <textarea id="description" name="description" rows="4" class="textarea-input">{{ old('description', $store->description) }}</textarea>
                </div>

                {{-- 🖼️ الشعار الحالي --}}
                <div>
                    <x-label for="logo" :value="__('mall.store_logo')" />
                    <input type="file" name="logo" id="logo" class="file-input" />
                    @if($store->logo)
                        <img src="{{ asset('storage/'.$store->logo) }}" alt="{{ $store->name }}"
                             class="w-24 h-24 mt-3 object-cover rounded-lg shadow border border-gray-200 dark:border-gray-700">
                    @endif
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
