{{-- resources/views/dashboard/myads.blade.php --}}
<x-app-layout>
<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- ✅ التبويبات العلوية --}}
    <div class="flex flex-wrap items-center justify-center gap-3 mb-6">
        <a href="{{ route('ads.index', ['category' => 'realestate']) }}" class="tab-link {{ request('category')=='realestate' ? 'active':'' }}">
            <i class="fas fa-building"></i> {{ __('messages.real_estate') }}
        </a>
        <a href="{{ route('ads.index', ['category' => 'cars']) }}" class="tab-link {{ request('category')=='cars' ? 'active':'' }}">
            <i class="fas fa-car"></i> {{ __('messages.cars') }}
        </a>
        <a href="{{ route('ads.index', ['category' => 'services']) }}" class="tab-link {{ request('category')=='services' ? 'active':'' }}">
            <i class="fas fa-tools"></i> {{ __('messages.services') }}
        </a>
        <a href="{{ route('delni.taxi') }}" class="tab-link {{ request()->routeIs('delni.taxi') ? 'active':'' }}">
            <i class="fas fa-taxi"></i> {{ __('messages.delni_taxi') }}
        </a>
        <a href="{{ route('emergency_services.index') }}" class="tab-link {{ request()->routeIs('emergency_services.*') ? 'active':'' }}">
            <i class="fas fa-ambulance"></i> {{ __('messages.delni_emergency') }}
        </a>
    </div>

    {{-- 🟡 العنوان --}}
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4 flex items-center gap-2">
        <i class="fas fa-bullhorn text-yellow-500"></i> {{ __('messages.my_ads') }} ({{ $ads->total() }})
    </h1>

    {{-- 📊 بطاقات إحصائية --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="stat-card bg-yellow-100 dark:bg-yellow-600">
            <i class="fas fa-list text-yellow-600 dark:text-yellow-200 text-xl"></i>
            <h3>{{ __('messages.total_ads') }}</h3>
            <p>{{ $ads->total() }}</p>
        </div>
        <div class="stat-card bg-yellow-200 dark:bg-yellow-700">
            <i class="fas fa-star text-yellow-700 dark:text-yellow-300 text-xl"></i>
            <h3>{{ __('messages.featured') }}</h3>
            <p>{{ $featuredCount ?? 0 }}</p>
        </div>
        <div class="stat-card bg-gray-200 dark:bg-gray-700">
            <i class="fas fa-circle text-gray-600 dark:text-gray-300 text-xl"></i>
            <h3>{{ __('messages.normal') }}</h3>
            <p>{{ $normalCount ?? 0 }}</p>
        </div>
    </div>

    {{-- ⭐ تبويبات داخلية --}}
    <div class="flex flex-wrap items-center gap-3 mb-6">
        <a href="{{ route('dashboard.myads', ['featured' => 1]) }}" class="sub-tab {{ request('featured')==='1' ? 'active':'' }}">
            <i class="fas fa-star text-yellow-500"></i> {{ __('messages.my_featured_ads') }}
        </a>
        <a href="{{ route('dashboard.myads', ['featured' => 0]) }}" class="sub-tab {{ request('featured')==='0' ? 'active':'' }}">
            <i class="fas fa-circle text-gray-500"></i> {{ __('messages.my_normal_ads') }}
        </a>
        <a href="{{ route('dashboard.myads') }}" class="sub-tab {{ request('featured')=='' ? 'active':'' }}">
            <i class="fas fa-list"></i> {{ __('messages.all') }}
        </a>
    </div>

    {{-- ✅ نموذج الفلترة --}}
    <form method="GET" action="{{ route('dashboard.myads') }}" 
          class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6 bg-white dark:bg-gray-800 shadow rounded-xl p-4">

        <select name="city" class="input">
            <option value="">{{ __('messages.select_city') }}</option>
            @foreach(['دمشق','ريف دمشق','حلب','حمص','حماة','اللاذقية','طرطوس','السويداء','درعا','القنيطرة','إدلب','الرقة','دير الزور','الحسكة'] as $city)
                <option value="{{ $city }}" {{ request('city')==$city ? 'selected':'' }}>{{ $city }}</option>
            @endforeach
        </select>

        <select name="category" class="input">
            <option value="">{{ __('messages.select_category') }}</option>
            <option value="realestate" {{ request('category')=='realestate' ? 'selected':'' }}>{{ __('messages.real_estate') }}</option>
            <option value="cars" {{ request('category')=='cars' ? 'selected':'' }}>{{ __('messages.cars') }}</option>
            <option value="services" {{ request('category')=='services' ? 'selected':'' }}>{{ __('messages.services') }}</option>
        </select>

        <select name="featured" class="input">
            <option value="">{{ __('messages.featured_status') }}</option>
            <option value="1" {{ request('featured')=='1' ? 'selected':'' }}>⭐ {{ __('messages.featured') }}</option>
            <option value="0" {{ request('featured')=='0' ? 'selected':'' }}>⚪ {{ __('messages.normal') }}</option>
        </select>

        <select name="sort" class="input">
            <option value="">{{ __('messages.sort_by') }}</option>
            <option value="latest" {{ request('sort')=='latest'?'selected':'' }}>{{ __('messages.latest') }}</option>
            <option value="price_desc" {{ request('sort')=='price_desc'?'selected':'' }}>{{ __('messages.price_high') }}</option>
            <option value="price_asc" {{ request('sort')=='price_asc'?'selected':'' }}>{{ __('messages.price_low') }}</option>
        </select>

        <div class="flex gap-2">
            <button type="submit" class="btn-yellow w-full">
                <i class="fas fa-search"></i> {{ __('messages.search') }}
            </button>
            <a href="{{ route('dashboard.myads') }}" class="btn-gray w-full">
                <i class="fas fa-undo"></i> {{ __('messages.reset') }}
            </a>
        </div>
    </form>

    {{-- 🎛️ زر تبديل العرض --}}
    <div class="flex justify-end mb-4">
        <button id="toggleView" class="btn-yellow">
            <i class="fas fa-th-large"></i> / <i class="fas fa-list"></i> {{ __('messages.toggle_view') }}
        </button>
    </div>

    {{-- 🖼️ عرض الإعلانات --}}
    <div id="adsContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($ads as $ad)
            @php
                $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
                $firstImage = $images[0] ?? 'placeholder.png';
            @endphp

            {{-- ✅ البطاقة --}}
            <div class="ad-card {{ $ad->is_featured ? 'border-yellow-400':'border-gray-200 dark:border-gray-700' }}">
                @if($ad->is_featured)
                    <span class="badge-featured"><i class="fas fa-star"></i></span>
                @endif

                {{-- صورة --}}
                    <a href="{{ route('ads.show', $ad->slug) }}">
                    <img src="{{ asset('storage/'.$firstImage) }}" 
                         onerror="this.onerror=null;this.src='{{ asset('storage/placeholder.png') }}';"
                         class="w-full h-40 object-cover rounded-t-xl" alt="ad">
                </a>

                {{-- محتوى --}}
                <div class="p-4 flex flex-col justify-between flex-1 content">
                    <div>
                        <h2 class="font-bold text-base truncate text-gray-900 dark:text-white">{{ $ad->title }}</h2>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                            <i class="fas fa-map-marker-alt text-red-500"></i> {{ $ad->city }}
                        </p>
                        <p class="price">
                            <i class="fas fa-dollar-sign"></i> {{ number_format($ad->price) }} {{ __('messages.currency') }}
                        </p>
                    </div>

                    {{-- أزرار --}}
                    <div class="flex flex-wrap justify-between mt-3 gap-2 actions">
                        <a href="{{ route('dashboard.ads.edit', $ad->id) }}" class="btn-blue">
                            <i class="fas fa-edit"></i> {{ __('messages.edit') }}
                        </a>
                        <form action="{{ route('dashboard.ads.destroy', $ad->id) }}" method="POST" onsubmit="return confirm('{{ __('messages.confirm_delete') }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-red">
                                <i class="fas fa-trash"></i> {{ __('messages.delete') }}
                            </button>
                        </form>
                        @if(!$ad->is_featured)
                            <a href="{{ route('dashboard.ads.feature', $ad->id) }}" class="btn-yellow">
                                <i class="fas fa-star"></i> {{ __('messages.make_featured') }}
                            </a>
                        @else
                            <a href="{{ route('dashboard.ads.unfeature', $ad->id) }}" class="btn-gray">
                                <i class="fas fa-ban"></i> {{ __('messages.remove_featured') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center col-span-4 text-gray-500 dark:text-gray-400 mt-8">
                <i class="fas fa-exclamation-circle"></i> {{ __('messages.no_ads_found') }}
            </p>
        @endforelse
    </div>

    {{-- 📄 روابط التصفح --}}
    <div class="mt-10">{{ $ads->links() }}</div>
</div>

{{-- ✅ Script Toggle Grid/List --}}
<script>
    const toggleBtn = document.getElementById('toggleView');
    let currentView = "{{ auth()->user()->ads_view ?? 'grid' }}"; 

    function applyView() {
        document.querySelectorAll('.ad-card').forEach(card => {
            if (currentView === 'grid') {
                card.classList.remove('list-view');
                card.classList.add('grid-view');
            } else {
                card.classList.remove('grid-view');
                card.classList.add('list-view');
            }
        });
    }

    applyView();

    toggleBtn.addEventListener('click', () => {
        currentView = (currentView === 'grid') ? 'list':'grid';
        applyView();

        fetch("{{ route('dashboard.saveView') }}", {
            method:"POST",
            headers:{
                "X-CSRF-TOKEN":"{{ csrf_token() }}",
                "Content-Type":"application/json"
            },
            body: JSON.stringify({ view: currentView })
        });
    });
</script>
</x-app-layout>
