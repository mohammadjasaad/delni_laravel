<x-main-layout>
    <div class="max-w-7xl mx-auto px-4 py-10">

        {{-- ✅ صف الأيقونات --}}
        <div class="flex justify-center flex-wrap gap-4 mb-8">
            <a href="{{ route('ads.index', ['category' => 'عقارات']) }}"
               class="flex items-center gap-2 px-5 py-2 rounded-full shadow @if(request('category') == 'عقارات') bg-yellow-500 text-white @else bg-gray-100 text-gray-800 @endif">
                🏠 <span class="font-semibold">عقارات</span>
            </a>
            <a href="{{ route('ads.index', ['category' => 'سيارات']) }}"
               class="flex items-center gap-2 px-5 py-2 rounded-full shadow @if(request('category') == 'سيارات') bg-yellow-500 text-white @else bg-gray-100 text-gray-800 @endif">
                🚗 <span class="font-semibold">سيارات</span>
            </a>
            <a href="{{ route('ads.index', ['category' => 'خدمات']) }}"
               class="flex items-center gap-2 px-5 py-2 rounded-full shadow @if(request('category') == 'خدمات') bg-yellow-500 text-white @else bg-gray-100 text-gray-800 @endif">
                🛠️ <span class="font-semibold">خدمات</span>
            </a>
            <a href="{{ route('emergency.index') }}"
               class="flex items-center gap-2 px-5 py-2 rounded-full shadow bg-red-100 text-red-800 hover:bg-red-200">
                🆘 <span class="font-semibold">دلني عاجل</span>
            </a>
            <a href="{{ route('order.taxi') }}"
               class="flex items-center gap-2 px-5 py-2 rounded-full shadow bg-yellow-400 text-black font-bold hover:bg-yellow-500 transition">
                🚖 Delni Taxi
            </a>
        </div>

        {{-- ✅ عنوان الصفحة --}}
        <h1 class="text-3xl font-extrabold text-center text-yellow-600 mb-10">
            🗂️ {{ __('messages.all_ads') }}
        </h1>

        {{-- ✅ نموذج الفلترة --}}
        <form method="GET" action="{{ route('ads.index') }}" class="bg-white p-6 rounded-2xl shadow-md mb-12 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            {{-- المدينة كتابة --}}
            <div>
                <label for="city_text" class="block mb-2 text-sm font-semibold text-gray-700">{{ __('messages.search_city') }}</label>
                <input type="text" name="city_text" id="city_text" dir="rtl" lang="ar"
                       value="{{ request('city_text') }}" placeholder="{{ __('messages.search_city') }}"
                       class="w-full rounded-xl border border-gray-300 p-3 text-right focus:ring-2 focus:ring-yellow-400">
            </div>

            {{-- المدينة قائمة --}}
            <div>
                <label for="city" class="block mb-2 text-sm font-semibold text-gray-700">{{ __('messages.city') }}</label>
                <select name="city" id="city" class="w-full rounded-xl border-gray-300 p-3 text-right focus:ring-2 focus:ring-yellow-400">
                    <option value="">{{ __('messages.select_city') }}</option>
                    @foreach(['دمشق','ريف دمشق','حلب','حمص','حماة','اللاذقية','طرطوس','السويداء','درعا','القنيطرة','إدلب','الرقة','دير الزور','الحسكة'] as $city)
                        <option value="{{ $city }}" @if(request('city') == $city) selected @endif>{{ $city }}</option>
                    @endforeach
                </select>
            </div>

            {{-- التصنيف --}}
            <div>
                <label for="category" class="block mb-2 text-sm font-semibold text-gray-700">{{ __('messages.category') }}</label>
                <select name="category" id="category" class="w-full rounded-xl border-gray-300 p-3 text-right focus:ring-2 focus:ring-yellow-400">
                    <option value="">{{ __('messages.select_category') }}</option>
                    <option value="عقارات" @if(request('category') == 'عقارات') selected @endif>عقارات</option>
                    <option value="سيارات" @if(request('category') == 'سيارات') selected @endif>سيارات</option>
                    <option value="خدمات" @if(request('category') == 'خدمات') selected @endif>خدمات</option>
                </select>
            </div>

            {{-- السعر الأدنى --}}
            <div>
                <label for="min_price" class="block mb-2 text-sm font-semibold text-gray-700">{{ __('messages.min_price') }}</label>
                <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}"
                       placeholder="مثلاً 100000"
                       class="w-full rounded-xl border-gray-300 p-3 text-right focus:ring-2 focus:ring-yellow-400">
            </div>

            {{-- السعر الأعلى --}}
            <div>
                <label for="max_price" class="block mb-2 text-sm font-semibold text-gray-700">{{ __('messages.max_price') }}</label>
                <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}"
                       placeholder="مثلاً 500000"
                       class="w-full rounded-xl border-gray-300 p-3 text-right focus:ring-2 focus:ring-yellow-400">
            </div>

            {{-- فقط المميز --}}
            <div>
                <label for="is_featured" class="block mb-2 text-sm font-semibold text-gray-700">⭐ {{ __('messages.featured_only') }}</label>
                <select name="is_featured" id="is_featured" class="w-full rounded-xl border-gray-300 p-3 text-right focus:ring-2 focus:ring-yellow-400">
                    <option value="">{{ __('messages.select_option') }}</option>
                    <option value="1" @if(request('is_featured') === '1') selected @endif>{{ __('messages.featured_only_yes') }}</option>
                    <option value="0" @if(request('is_featured') === '0') selected @endif>{{ __('messages.featured_only_no') }}</option>
                </select>
            </div>

            {{-- أزرار الفلترة --}}
            <div class="col-span-full flex justify-end gap-4 pt-2">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold px-6 py-3 rounded-xl shadow">
                    🔍 {{ __('messages.filter') }}
                </button>
                <a href="{{ route('ads.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-6 py-3 rounded-xl shadow">
                    🔄 {{ __('messages.reset') }}
                </a>
            </div>
        </form>

        {{-- ✅ عرض الإعلانات --}}
        @if($ads->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($ads as $ad)
                    @php
                        $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
                        $firstImage = $images && count($images) > 0 ? $images[0] : null;
                    @endphp

                    <a href="{{ route('ads.show', $ad->id) }}"
                       class="relative bg-white rounded-2xl shadow-md hover:shadow-xl transition overflow-hidden block group border-2 {{ $ad->is_featured ? 'border-yellow-400' : 'border-gray-100' }}">

                        {{-- ⭐ شارة إعلان مميز --}}
                        @if($ad->is_featured)
                            <div class="absolute top-0 right-0 bg-yellow-400 text-white text-xs font-bold px-3 py-1 rounded-bl">
                                ⭐ إعلان مميز
                            </div>
                        @endif

                        {{-- صورة الإعلان --}}
                        <div class="relative">
                            @if($firstImage)
                                <img src="{{ asset($firstImage) }}" alt="Ad Image"
                                     class="w-full h-48 object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <img src="/placeholder.png" alt="No Image" class="w-full h-48 object-cover opacity-60">
                            @endif
                            <div class="absolute top-2 left-2 bg-white text-xs px-3 py-1 rounded shadow text-gray-700 font-semibold">
                                {{ $ad->category }}
                            </div>
                        </div>

                        {{-- معلومات الإعلان --}}
                        <div class="p-4 space-y-1">
                            <h3 class="text-lg font-bold text-gray-800 truncate">{{ $ad->title }}</h3>
                            <p class="text-sm text-gray-600 truncate">📍 {{ $ad->city }}</p>
                            <p class="text-md font-bold text-yellow-600">💰 {{ number_format($ad->price) }} {{ __('messages.currency') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- ✅ روابط الصفحات --}}
            <div class="mt-10 text-center">
                {{ $ads->links() }}
            </div>
        @else
            <p class="text-gray-600 text-center mt-10 text-lg">{{ __('messages.no_ads_found') }}</p>
        @endif

    </div>
</x-main-layout>
