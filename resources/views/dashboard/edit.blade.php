{{-- resources/views/dashboard/edit.blade.php --}}
<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">{{ __('messages.edit_ad') }}</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('dashboard.ads.update', $ad->id) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- العنوان --}}
            <div>
                <x-label for="title" :value="__('messages.title')" />
                <x-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ old('title', $ad->title) }}" />
            </div>

            {{-- الوصف --}}
            <div>
                <x-label for="description" :value="__('messages.description')" />
                <textarea id="description" name="description" rows="4" class="w-full rounded border-gray-300">{{ old('description', $ad->description) }}</textarea>
            </div>

            {{-- السعر --}}
            <div>
                <x-label for="price" :value="__('messages.price')" />
                <x-input id="price" class="block mt-1 w-full" type="number" name="price" value="{{ old('price', $ad->price) }}" />
            </div>

            {{-- المدينة --}}
            <div>
                <x-label for="city" :value="__('messages.city')" />
                <select id="city" name="city" class="block mt-1 w-full border-gray-300 rounded">
                    @foreach(['دمشق','ريف دمشق','حلب','حمص','حماة','اللاذقية','طرطوس','السويداء','درعا','القنيطرة','إدلب','الرقة','دير الزور','الحسكة'] as $city)
                        <option value="{{ $city }}" {{ (old('city', $ad->city) == $city) ? 'selected' : '' }}>{{ $city }}</option>
                    @endforeach
                </select>
            </div>

            {{-- التصنيف --}}
            <div>
                <x-label for="category" :value="__('messages.category')" />
                <select id="category" name="category" class="block mt-1 w-full border-gray-300 rounded">
                    <option value="عقارات" {{ (old('category', $ad->category) == 'عقارات') ? 'selected' : '' }}>عقارات</option>
                    <option value="سيارات" {{ (old('category', $ad->category) == 'سيارات') ? 'selected' : '' }}>سيارات</option>
                </select>
            </div>

            {{-- الصور الجديدة (اختياري) --}}
            <div>
                <x-label for="images" :value="__('messages.images')" />
                <input type="file" name="images[]" id="images" multiple class="w-full border-gray-300 rounded" />
                <p class="text-sm text-gray-500 mt-1">{{ __('messages.upload_new_images_optional') }}</p>
            </div>

            {{-- زر الإرسال --}}
            <div class="flex justify-end">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                    {{ __('messages.save_changes') }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
