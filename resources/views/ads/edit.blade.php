{{-- resources/views/ads/edit.blade.php --}}
<x-main-layout>
    <div class="max-w-4xl mx-auto px-4 py-10">

        {{-- ✅ العنوان --}}
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">
            {{ __('messages.edit_ad') }}
        </h1>

        {{-- ✅ الأخطاء --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-100 text-red-800 p-4 rounded shadow">
                <ul class="list-disc pl-6 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ✅ نموذج التعديل --}}
        <form action="{{ route('ads.update', $ad->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-xl shadow space-y-6">
            @csrf
            @method('PUT')

            {{-- 📝 العنوان --}}
            <div>
                <x-label for="title" :value="__('messages.title')" />
                <x-input id="title" type="text" name="title" value="{{ $ad->title }}" class="w-full mt-1" required />
            </div>

            {{-- 🧾 الوصف --}}
            <div>
                <x-label for="description" :value="__('messages.description')" />
                <textarea id="description" name="description" rows="4" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500" required>{{ $ad->description }}</textarea>
            </div>

            {{-- 💰 السعر --}}
            <div>
                <x-label for="price" :value="__('messages.price')" />
                <x-input id="price" type="number" name="price" value="{{ $ad->price }}" class="w-full mt-1" required />
            </div>

            {{-- 🏙️ المدينة --}}
            <div>
                <x-label for="city" :value="__('messages.city')" />
                <select id="city" name="city" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500" required>
                    @foreach($cities as $city)
                        <option value="{{ $city }}" @if($ad->city == $city) selected @endif>{{ $city }}</option>
                    @endforeach
                </select>
            </div>

            {{-- 🗂️ التصنيف --}}
            <div>
                <x-label for="category" :value="__('messages.category')" />
                <select id="category" name="category" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500" required>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" @if($ad->category == $category) selected @endif>{{ $category }}</option>
                    @endforeach
                </select>
            </div>

            {{-- 🖼️ الصور الجديدة --}}
            <div>
                <x-label for="images" :value="__('messages.images')" />
                <input type="file" name="images[]" id="images" multiple class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500" />
                <p class="text-sm text-gray-500 mt-1">{{ __('messages.upload_new_images_note') }}</p>
            </div>

            {{-- ✅ الصور الحالية --}}
            @php
                $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
            @endphp

            @if($images && count($images) > 0)
                <div>
                    <h3 class="text-sm font-medium text-gray-700 mb-2">{{ __('messages.current_images') }}</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach($images as $image)
                            <img src="{{ asset('storage/' . $image) }}" alt="Image" class="w-full h-32 object-cover rounded shadow">
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ✅ زر التحديث --}}
            <div>
                <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold px-6 py-3 rounded-xl">
                    {{ __('messages.update') }}
                </button>
            </div>
        </form>
    </div>
</x-main-layout>
