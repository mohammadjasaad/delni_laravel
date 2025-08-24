<x-main-layout title="{{ __('messages.all_ads') }}">
  <div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-extrabold text-center text-yellow-600 mb-10">
      🗂️ {{ __('messages.all_ads') }}
    </h1>

    <!-- زر الفلاتر (بدون أي متغيرات PHP) -->
    <div class="mb-6"
         x-data="{ open: {{ request()->hasAny(['q','city','category','min_price','max_price','is_featured']) ? 'true' : 'false' }} }">
      <button id="toggleFiltersBtn"
              @click="open = !open"
              type="button"
              class="bg-yellow-500 text-white font-semibold py-2 px-4 rounded-md shadow hover:bg-yellow-600">
        <span x-text="open ? '{{ __('messages.hide_filters') }}' : '{{ __('messages.show_filters') }}'"></span>
      </button>

      <div id="adsFiltersBox" class="mt-4" :class="open ? '' : 'hidden'">
        <form method="GET" action="{{ route('ads.index') }}"
              class="bg-white p-4 rounded-xl shadow grid grid-cols-12 gap-3 items-center">
          <input type="text" name="q" value="{{ request('q') }}"
                 placeholder="🔍 {{ __('messages.search') }}"
                 class="col-span-12 md:col-span-2 rounded-md border-gray-300 p-2 focus:ring-yellow-400" />

          <select name="city"
                  class="col-span-6 md:col-span-2 rounded-md border-gray-300 p-2 focus:ring-yellow-400">
            <option value="">{{ __('messages.select_city') }}</option>
            {{-- أضف المدن هنا إذا رغبت --}}
          </select>

          <select name="category"
                  class="col-span-6 md:col-span-2 rounded-md border-gray-300 p-2 focus:ring-yellow-400">
            <option value="">{{ __('messages.select_category') }}</option>
            <option value="realestate" @selected(request('category') == 'realestate')>{{ __('messages.real_estate') }}</option>
            <option value="cars" @selected(request('category') == 'cars')>{{ __('messages.cars') }}</option>
            <option value="services" @selected(request('category') == 'services')>{{ __('messages.services') }}</option>
          </select>

          <input type="number" name="min_price" value="{{ request('min_price') }}"
                 placeholder="{{ __('messages.min_price') }}"
                 class="col-span-6 md:col-span-1 rounded-md border-gray-300 p-2 focus:ring-yellow-400" />

          <input type="number" name="max_price" value="{{ request('max_price') }}"
                 placeholder="{{ __('messages.max_price') }}"
                 class="col-span-6 md:col-span-1 rounded-md border-gray-300 p-2 focus:ring-yellow-400" />

          <select name="is_featured"
                  class="col-span-6 md:col-span-2 rounded-md border-gray-300 p-2 focus:ring-yellow-400">
            <option value="">{{ __('messages.select_option') }}</option>
            <option value="1" @selected(request('is_featured') === '1')>{{ __('messages.featured_only_yes') }}</option>
            <option value="0" @selected(request('is_featured') === '0')>{{ __('messages.featured_only_no') }}</option>
          </select>

          <div class="col-span-12 md:col-span-2 flex gap-2">
            <button type="submit" class="bg-yellow-500 text-white font-semibold py-2 px-4 rounded-md shadow hover:bg-yellow-600">
              🔍 {{ __('messages.filter') }}
            </button>
            <a href="{{ route('ads.index') }}"
               class="bg-gray-200 text-gray-800 font-semibold py-2 px-4 rounded-md shadow hover:bg-gray-300">
              🔄 {{ __('messages.reset') }}
            </a>
          </div>
        </form>
      </div>
    </div>

    <!-- شبكة الإعلانات -->
    @if(isset($ads) && count($ads))
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($ads as $ad)
          <div class="bg-white rounded-xl shadow p-4">
            <h3 class="text-lg font-bold mb-2">{{ $ad->title }}</h3>
            <p class="text-red-600 font-bold">{{ number_format($ad->price) }} {{ __('messages.currency') }}</p>
            <p class="text-gray-500 text-sm mt-1">{{ __('messages.city') }}: {{ $ad->city }}</p>
            <a href="{{ route('ads.show', $ad->id) }}"
               class="block mt-3 text-center bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 rounded">
              {{ __('messages.view_ad') }}
            </a>
          </div>
        @endforeach
      </div>
    @else
      <p class="text-gray-600 text-center mt-10 text-lg">{{ __('messages.no_ads_found') }}</p>
    @endif
  </div>
</x-main-layout>
