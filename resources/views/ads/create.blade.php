{{-- resources/views/ads/create.blade.php --}}
<x-main-layout>
    <div class="max-w-3xl mx-auto px-4 py-10">

        {{-- ✅ عنوان الصفحة --}}
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">
            {{ __('messages.add_ad') }}
        </h1>

        {{-- ✅ عرض الأخطاء --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-100 text-red-800 p-4 rounded">
                <ul class="list-disc pl-6 rtl:pr-6 rtl:pl-0 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ✅ نموذج الإضافة --}}
          <form action="{{ route('dashboard.ads.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- 📝 العنوان --}}
            <div>
                <x-label for="title" :value="__('messages.title')" />
                <x-input id="title" type="text" name="title" class="w-full mt-1" required />
            </div>

            {{-- 🧾 الوصف --}}
            <div>
                <x-label for="description" :value="__('messages.description')" />
                <textarea id="description" name="description" rows="4" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500" required></textarea>
            </div>

            {{-- 💰 السعر --}}
            <div>
                <x-label for="price" :value="__('messages.price')" />
                <x-input id="price" type="number" name="price" class="w-full mt-1" required />
            </div>

            {{-- 🏙️ المدينة --}}
            <div>
                <x-label for="city" :value="__('messages.city')" />
                <select id="city" name="city" required class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                    <option value="">{{ __('messages.select_city') }}</option>
                    @foreach($cities as $city)
                        <option value="{{ $city }}">{{ $city }}</option>
                    @endforeach
                </select>
            </div>

            {{-- 🗂️ القسم --}}
            <div>
                <x-label for="category" :value="__('messages.category')" />
                <select id="category" name="category" required class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                    <option value="">{{ __('messages.select_category') }}</option>
                    <option value="realestate">{{ __('messages.real_estate') }}</option>
                    <option value="cars">{{ __('messages.cars') }}</option>
                    <option value="services">{{ __('messages.services') }}</option>
                </select>
            </div>

            {{-- 🖼️ الصور --}}
            <div>
                <x-label for="images" :value="__('messages.images')" />
                <input type="file" name="images[]" id="images" multiple required
                       class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500" />
            </div>

            {{-- ✅ زر الإرسال --}}
            <div class="pt-4">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold px-6 py-3 rounded-xl w-full">
                    {{ __('messages.submit') }}
                </button>
            </div>
        </form>

    </div>
</x-main-layout>
