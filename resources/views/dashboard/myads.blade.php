<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-4">

        <!-- 🧭 العنوان الرئيسي -->
        <h1 class="text-2xl font-bold mb-6 text-gray-800">{{ __('messages.my_ads') }}</h1>

        <!-- 🔍 نموذج الفلترة -->
        <form method="GET" action="{{ route('dashboard.myads') }}" class="mb-6 flex flex-wrap gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('messages.city') }}</label>
                <input type="text" name="city" value="{{ request('city') }}"
                       class="border border-gray-300 rounded px-3 py-1">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('messages.category') }}</label>
                <input type="text" name="category" value="{{ request('category') }}"
                       class="border border-gray-300 rounded px-3 py-1">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('messages.featured_status') }}</label>
                <select name="is_featured" class="border border-gray-300 rounded px-3 py-1">
                    <option value="">{{ __('messages.all') }}</option>
                    <option value="1" {{ request('is_featured') == '1' ? 'selected' : '' }}>⭐ {{ __('messages.featured_only') }}</option>
                    <option value="0" {{ request('is_featured') === '0' ? 'selected' : '' }}>{{ __('messages.normal_only') }}</option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-1 rounded">
                    {{ __('messages.filter') }}
                </button>
                <a href="{{ route('dashboard.myads') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-1 rounded">
                    {{ __('messages.reset') }}
                </a>
            </div>
        </form>

        <!-- 🖼️ عرض الإعلانات -->
        @if($ads->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($ads as $ad)
                    @php
                        $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
                        $firstImage = $images && count($images) > 0 ? $images[0] : null;
                    @endphp

                    <div class="relative bg-white rounded-lg shadow hover:shadow-md transition overflow-hidden border-2 {{ $ad->is_featured ? 'border-yellow-400' : 'border-gray-100' }}">
                        
                        <!-- ⭐ شارة إعلان مميز -->
                        @if($ad->is_featured)
                            <div class="absolute top-2 left-2 bg-yellow-400 text-white text-xs font-bold px-2 py-1 rounded shadow">
                                ⭐ {{ __('messages.featured_ad') }}
                            </div>
                        @endif

                        <!-- 🖼️ صورة الإعلان -->
                        <a href="{{ route('ads.show', $ad->id) }}">
                            @if($firstImage)
                                <img src="{{ asset($firstImage) }}" alt="Ad Image" class="w-full h-48 object-cover">
                            @else
                                <img src="/placeholder.png" alt="No Image" class="w-full h-48 object-cover">
                            @endif

                            <div class="p-4 space-y-2">
                                <h2 class="text-lg font-semibold text-gray-800">{{ $ad->title }}</h2>
                                <p class="text-gray-600">{{ __('messages.price') }}: {{ number_format($ad->price) }}</p>
                                <p class="text-gray-500 text-sm">{{ __('messages.city') }}: {{ $ad->city }}</p>
                                <p class="text-xs text-gray-400">{{ $ad->created_at->diffForHumans() }}</p>
                            </div>
                        </a>

                        <!-- 🛠️ أدوات التحكم -->
                        <div class="px-4 pb-4 flex flex-col gap-2">

                            <!-- ⭐ زر تمييز أو إزالة التمييز -->
                            @if($ad->is_featured)
                                <form method="POST" action="{{ route('ads.unfeature', $ad->id) }}">
                                    @csrf
                                    <button type="submit"
                                            class="w-full bg-gray-300 hover:bg-gray-400 text-gray-800 px-3 py-1 rounded text-sm">
                                        ❌ {{ __('messages.unfeature_ad') }}
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('ads.feature', $ad->id) }}">
                                    @csrf
                                    <button type="submit"
                                            class="w-full bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                        ⭐ {{ __('messages.feature_ad') }}
                                    </button>
                                </form>
                            @endif

                            <!-- ✏️ زر تعديل -->
                            <a href="{{ route('dashboard.ads.edit', $ad->id) }}"
                               class="w-full text-center bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                ✏️ {{ __('messages.edit') }}
                            </a>

                            <!-- 🗑️ زر حذف -->
                            <form method="POST" action="{{ route('dashboard.ads.destroy', $ad->id) }}"
                                  onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                    🗑️ {{ __('messages.delete') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600 mt-6 text-center">{{ __('messages.no_ads_yet') }}</p>
        @endif

    </div>
</x-app-layout>
