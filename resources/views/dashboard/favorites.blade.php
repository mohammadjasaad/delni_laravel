{{-- resources/views/dashboard/favorites.blade.php --}}
<x-app-layout>
<div class="max-w-7xl mx-auto px-4 py-8">

{{-- ✅ التبويبات العلوية العامة --}}
<div class="flex flex-wrap items-center justify-center gap-3 mb-6">
    <a href="{{ route('ads.index', ['category' => 'realestate']) }}"
       class="px-5 py-2 rounded-full text-sm font-semibold transition
       {{ request('category') == 'realestate' ? 'bg-yellow-400 text-black' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600' }}">
        <i class="fas fa-building"></i> {{ __('messages.real_estate') }}
    </a>
    <a href="{{ route('ads.index', ['category' => 'cars']) }}"
       class="px-5 py-2 rounded-full text-sm font-semibold transition
       {{ request('category') == 'cars' ? 'bg-yellow-400 text-black' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600' }}">
        <i class="fas fa-car"></i> {{ __('messages.cars') }}
    </a>
    <a href="{{ route('ads.index', ['category' => 'services']) }}"
       class="px-5 py-2 rounded-full text-sm font-semibold transition
       {{ request('category') == 'services' ? 'bg-yellow-400 text-black' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600' }}">
        <i class="fas fa-tools"></i> {{ __('messages.services') }}
    </a>
    <a href="{{ route('delni.taxi') }}"
       class="px-5 py-2 rounded-full text-sm font-semibold transition
       {{ request()->routeIs('delni.taxi') ? 'bg-yellow-400 text-black' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600' }}">
        <i class="fas fa-taxi"></i> {{ __('messages.delni_taxi') }}
    </a>
    <a href="{{ route('emergency_services.index') }}"
       class="px-5 py-2 rounded-full text-sm font-semibold transition
       {{ request()->routeIs('emergency_services.*') ? 'bg-yellow-400 text-black' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600' }}">
       <i class="fas fa-ambulance"></i> {{ __('messages.delni_emergency') }}
    </a>
</div>

    {{-- 🧭 العنوان --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
            ❤️ {{ __('messages.favorites') }} ({{ $favorites->total() }})
        </h1>
        {{-- 🎛️ زر تبديل العرض --}}
        <button id="toggleView"
                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-th-large"></i> / <i class="fas fa-list"></i> {{ __('messages.toggle_view') }}
        </button>
    </div>

    {{-- ✅ نموذج الفلترة --}}
    <form method="GET" action="{{ route('dashboard.favorites') }}" 
          class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6 bg-white dark:bg-gray-800 shadow rounded-xl p-4">
        {{-- 🌍 المدينة --}}
        <select name="city" class="border rounded-lg p-2 dark:bg-gray-700 dark:text-gray-200">
            <option value="">{{ __('messages.select_city') }}</option>
            @foreach(['دمشق','ريف دمشق','حلب','حمص','حماة','اللاذقية','طرطوس','السويداء','درعا','القنيطرة','إدلب','الرقة','دير الزور','الحسكة'] as $city)
                <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
            @endforeach
        </select>

        {{-- 📂 التصنيف --}}
        <select name="category" class="border rounded-lg p-2 dark:bg-gray-700 dark:text-gray-200">
            <option value="">{{ __('messages.select_category') }}</option>
            <option value="realestate" {{ request('category') == 'realestate' ? 'selected' : '' }}>🏠 {{ __('messages.real_estate') }}</option>
            <option value="cars" {{ request('category') == 'cars' ? 'selected' : '' }}>🚗 {{ __('messages.cars') }}</option>
            <option value="services" {{ request('category') == 'services' ? 'selected' : '' }}>🛠️ {{ __('messages.services') }}</option>
        </select>

        {{-- ⭐ حالة الإعلان --}}
        <select name="featured" class="border rounded-lg p-2 dark:bg-gray-700 dark:text-gray-200">
            <option value="">{{ __('messages.featured_status') }}</option>
            <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>⭐ {{ __('messages.featured') }}</option>
            <option value="0" {{ request('featured') == '0' ? 'selected' : '' }}>⚪ {{ __('messages.normal') }}</option>
        </select>

        {{-- 🔄 الترتيب --}}
        <select name="sort" class="border rounded-lg p-2 dark:bg-gray-700 dark:text-gray-200">
            <option value="">{{ __('messages.sort_by') }}</option>
            <option value="latest" {{ request('sort')=='latest'?'selected':'' }}>{{ __('messages.latest') }}</option>
            <option value="price_desc" {{ request('sort')=='price_desc'?'selected':'' }}>{{ __('messages.price_high') }}</option>
            <option value="price_asc" {{ request('sort')=='price_asc'?'selected':'' }}>{{ __('messages.price_low') }}</option>
        </select>

        {{-- 🔎 زر البحث / إعادة تعيين --}}
        <div class="flex gap-2">
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg w-full">
                <i class="fas fa-search"></i> {{ __('messages.search') }}
            </button>
            <a href="{{ route('dashboard.favorites') }}" 
               class="bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 px-4 py-2 rounded-lg w-full text-center text-gray-800 dark:text-gray-200">
                <i class="fas fa-undo"></i> {{ __('messages.reset') }}
            </a>
        </div>
    </form>

    @if($favorites->count() > 0)
        <div id="favoritesContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($favorites as $ad)
                @php
                    $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
                    $firstImage = !empty($images[0]) ? asset('storage/'.$images[0]) : asset('storage/placeholder.png');
                @endphp

                {{-- 🟨 بطاقة إعلان --}}
                <div class="favorite-card grid-view relative bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-2xl transition overflow-hidden border {{ $ad->is_featured ? 'border-yellow-400' : 'border-gray-200 dark:border-gray-700' }}">
                    
                    {{-- ⭐ شارة إعلان مميز --}}
                    @if($ad->is_featured)
                        <div class="absolute top-2 left-2 bg-yellow-400 text-black text-xs font-bold px-2 py-1 rounded shadow">
                            ⭐ {{ __('messages.featured_ad') }}
                        </div>
                    @endif

                    {{-- 🖼️ صورة الإعلان --}}
                    <a href="{{ route('ads.show', $ad->slug) }}">
                        <img src="{{ $firstImage }}" alt="{{ $ad->title }}" class="w-full h-48 object-cover">
                        <div class="p-4 space-y-2">
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-white truncate">
                                {{ $ad->title }}
                            </h2>
                            <p class="text-gray-600 dark:text-gray-300">
                                <i class="fas fa-dollar-sign"></i> {{ number_format($ad->price) }} {{ __('messages.currency') }}
                            </p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">
                                <i class="fas fa-map-marker-alt"></i> {{ $ad->city }}
                            </p>
                            <p class="text-xs text-gray-400 dark:text-gray-500">
                                {{ $ad->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </a>

                    {{-- ❌ زر إزالة من المفضلة --}}
                    <div class="px-4 pb-4">
                        <form method="POST" action="{{ route('ads.unfavorite', $ad->slug) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                ❌ {{ __('messages.remove_favorite') }}
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- 📄 روابط التصفح --}}
        <div class="mt-10">
            {{ $favorites->links() }}
        </div>
    @else
        <p class="text-gray-600 dark:text-gray-400 mt-6 text-center">
            📌 {{ __('messages.no_favorites_yet') }}
        </p>
    @endif
</div>

{{-- ✅ Script Toggle Grid/List --}}
<script>
    const favoritesContainer = document.getElementById('favoritesContainer');
    const toggleBtn = document.getElementById('toggleView');
    let currentView = "grid";

    function applyView() {
        document.querySelectorAll('.favorite-card').forEach(card => {
            if (currentView === 'grid') {
                card.classList.remove('list-view', 'flex');
                card.classList.add('grid-view', 'block');
            } else {
                card.classList.remove('grid-view', 'block');
                card.classList.add('list-view', 'flex');
            }
        });
    }

    applyView();

    toggleBtn.addEventListener('click', () => {
        currentView = (currentView === 'grid') ? 'list' : 'grid';
        applyView();
    });
</script>
</x-app-layout>
