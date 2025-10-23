{{-- resources/views/mall/edit-ad.blade.php --}}
<x-app-layout title="✏️ {{ __('mall.edit_ad') }}">
    <div class="max-w-4xl mx-auto px-4 py-10">

        {{-- 🧭 العنوان --}}
        <h1 class="text-3xl font-bold text-center mb-8 text-gray-800 dark:text-gray-100">
            ✏️ {{ __('mall.edit_ad') }} - {{ $store->name }}
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
            <form action="{{ route('mall.ads.update', [$store->id, $ad->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- 📝 العنوان --}}
                <div>
                    <x-label for="title" :value="__('mall.title')" />
                    <x-input id="title" type="text" name="title" value="{{ old('title', $ad->title) }}" required autofocus />
                </div>

                {{-- 📂 التصنيف --}}
                <div>
                    <x-label for="category" :value="__('mall.category')" />
                    <select id="category" name="category" class="select-input" required>
                        <option value="realestate" {{ old('category', $ad->category) == 'realestate' ? 'selected' : '' }}>{{ __('mall.realestate') }}</option>
                        <option value="cars" {{ old('category', $ad->category) == 'cars' ? 'selected' : '' }}>{{ __('mall.cars') }}</option>
                        <option value="services" {{ old('category', $ad->category) == 'services' ? 'selected' : '' }}>{{ __('mall.services') }}</option>
                        <option value="furniture" {{ old('category', $ad->category) == 'furniture' ? 'selected' : '' }}>{{ __('mall.furniture') }}</option>
                        <option value="electronics" {{ old('category', $ad->category) == 'electronics' ? 'selected' : '' }}>{{ __('mall.electronics') }}</option>
                        <option value="others" {{ old('category', $ad->category) == 'others' ? 'selected' : '' }}>{{ __('mall.others') }}</option>
                    </select>
                </div>

                {{-- 💰 السعر --}}
                <div>
                    <x-label for="price" :value="__('mall.price')" />
                    <x-input id="price" type="number" step="0.01" name="price" value="{{ old('price', $ad->price) }}" />
                </div>

                {{-- 🌍 المدينة --}}
                <div>
                    <x-label for="city" :value="__('mall.city')" />
                    <x-input id="city" type="text" name="city" value="{{ old('city', $ad->city) }}" />
                </div>

                {{-- 📝 الوصف --}}
                <div>
                    <x-label for="description" :value="__('mall.description')" />
                    <textarea id="description" name="description" rows="4" class="textarea-input">{{ old('description', $ad->description) }}</textarea>
                </div>

                {{-- 🖼️ الصور المتعددة --}}
                <div>
                    <x-label for="images" :value="__('mall.images')" />
                    <input type="file" name="images[]" id="images" multiple class="file-input" />

                    {{-- ✅ الصور الحالية --}}
                    @if(!empty($ad->images) && is_array($ad->images))
                        <div class="flex flex-wrap gap-3 mt-3">
                            @foreach($ad->images as $img)
                                <img src="{{ asset('storage/'.$img) }}" class="w-24 h-24 object-cover rounded border">
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- ⭐ مميزات الإعلان --}}
                <div class="flex items-center gap-6">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_featured" value="1" class="rounded border-gray-300 dark:border-gray-700" {{ old('is_featured', $ad->is_featured) ? 'checked' : '' }}>
                        <span>{{ __('mall.featured') }}</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_urgent" value="1" class="rounded border-gray-300 dark:border-gray-700" {{ old('is_urgent', $ad->is_urgent) ? 'checked' : '' }}>
                        <span>{{ __('mall.urgent') }}</span>
                    </label>
                </div>

                {{-- 📌 نوع الإعلان --}}
                <div>
                    <x-label for="type" :value="__('mall.type')" />
                    <select id="type" name="type" class="select-input">
                        <option value="offer" {{ old('type', $ad->type) == 'offer' ? 'selected' : '' }}>{{ __('mall.offer') }}</option>
                        <option value="request" {{ old('type', $ad->type) == 'request' ? 'selected' : '' }}>{{ __('mall.request') }}</option>
                    </select>
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
