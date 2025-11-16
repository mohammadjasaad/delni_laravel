{{-- resources/views/mall/dashboard.blade.php --}}
<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-10 space-y-12">

        {{-- 🏬 رأس المتجر --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6 flex flex-col md:flex-row items-center gap-6">
            <img src="{{ $store->logo ? asset('storage/'.$store->logo) : asset('storage/placeholder.png') }}"
                 alt="{{ $store->name }}"
                 class="w-28 h-28 rounded-full border border-gray-200 dark:border-gray-700 object-cover shadow">

            <div class="flex-1 space-y-2">
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $store->name }}</h1>
                <p class="text-gray-500 dark:text-gray-400">{{ $store->description ?? __('mall.no_description_available') }}</p>

                <div class="flex flex-wrap items-center gap-3">
                    <span class="px-4 py-1 text-sm bg-yellow-100 text-yellow-700 rounded-full">
                        📂 {{ __('mall.' . $store->category) }}
                    </span>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        <i class="fas fa-calendar-alt text-yellow-500"></i>
                        {{ __('mall.created_at') }}: {{ $store->created_at->format('Y-m-d') }}
                    </span>
                </div>
            </div>

<div class="flex flex-col gap-2">

    {{-- زر تعديل المتجر --}}
    <a href="{{ route('mall.edit', $store->id) }}" class="btn-yellow">
        ✏️ {{ __('mall.edit_store') }}
    </a>

    {{-- زر إضافة منتج جديد --}}
    <a href="{{ route('mall.products.create', $store->id) }}" 
       class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-center shadow">
        ➕ {{ __('mall.add_product') }}
    </a>

    {{-- زر العودة --}}
    <a href="{{ route('mall.index') }}" class="btn-gray">
        ⬅️ {{ __('mall.back') }}
    </a>

</div>
        </div>

        {{-- ✅ رسالة نجاح --}}
        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        {{-- 🗂️ شريط Tabs --}}
        <div class="flex flex-wrap gap-4 border-b border-gray-200 dark:border-gray-700 pb-2">
            <a href="#stats" class="tab-link active">📊 {{ __('mall.quick_stats') }}</a>
            <a href="#ads" class="tab-link">📢 {{ __('mall.my_ads') }}</a>
            <a href="#products" class="tab-link">📦 {{ __('mall.products') }}</a>
        </div>

        {{-- 📊 إحصائيات --}}
        <section id="stats" class="space-y-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">📊 {{ __('mall.quick_stats') }}</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-6">
                <div class="stat-card">⭐<p>{{ $store->featured_ads_count ?? 0 }}</p><h3>{{ __('mall.featured') }}</h3></div>
                <div class="stat-card">📢<p>{{ $store->ads_count ?? 0 }}</p><h3>{{ __('mall.my_ads') }}</h3></div>
                <div class="stat-card">💖<p>{{ $store->favorites_count ?? 0 }}</p><h3>{{ __('mall.favorites') }}</h3></div>
                <div class="stat-card">🔔<p>{{ $store->normal_ads_count ?? 0 }}</p><h3>{{ __('mall.normal_ads') }}</h3></div>
                <div class="stat-card">🔥<p>{{ $store->urgent_ads_count ?? 0 }}</p><h3>{{ __('mall.urgent_ads') }}</h3></div>
                <div class="stat-card">🚗<p>{{ $store->requested_ads_count ?? 0 }}</p><h3>{{ __('mall.requested_ads') }}</h3></div>
            </div>
        </section>

        {{-- 📢 إعلانات --}}
        <section id="ads" class="space-y-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">📢 {{ __('mall.my_ads') }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($store->ads as $ad)
                    <div class="ad-card group relative">
                        @if($ad->is_featured)
                            <span class="badge-featured">⭐ {{ __('mall.featured') }}</span>
                        @endif
                        <a href="{{ route('ads.show', $ad->id) }}">
                            <img src="{{ !empty($ad->images) && is_array($ad->images) && isset($ad->images[0]) 
                                        ? asset('storage/'.$ad->images[0]) 
                                        : asset('images/no-image.png') }}"
                                 alt="{{ $ad->title }}">
                        </a>
                        <div class="p-4 flex flex-col gap-2">
                            <h3 class="font-semibold text-gray-800 dark:text-white truncate">{{ $ad->title }}</h3>
                            <span class="price">{{ $ad->price }} {{ __('mall.currency') }}</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                🌍 {{ $ad->city }} | 📂 {{ __('mall.' . $ad->category) }}
                            </p>
                            <p class="text-xs text-gray-400">
                                {{ $ad->type === 'request' ? __('mall.request') : __('mall.offer') }}
                                @if($ad->is_urgent) 🔥 {{ __('mall.urgent') }} @endif
                            </p>
                            <div class="flex justify-between mt-2">
                                <a href="{{ route('ads.show', $ad->id) }}" class="btn-blue">👁️ {{ __('mall.view') }}</a>
                                @auth
                                    @include('components.partials.ad-actions', ['store' => $store, 'ad' => $ad])
                                @endauth
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400">{{ __('mall.no_ads') }}</p>
                @endforelse
            </div>
        </section>

        {{-- 📦 المنتجات --}}
<div class="flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">📦 {{ __('mall.products') }}</h2>

    @auth
    @endauth
</div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($store->products as $product)
                    <div class="ad-card group">
                        <a href="{{ route('mall.products.show', [$store->id, $product->id]) }}">
                            <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/no-image.png') }}"
                                 alt="{{ $product->name }}">
                        </a>
                        <div class="p-4 flex flex-col gap-2">
                            <h3 class="font-semibold text-gray-800 dark:text-white truncate">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2">{{ $product->description }}</p>
                            <span class="price">{{ $product->price }} {{ __('mall.currency') }}</span>
                            <a href="{{ route('mall.products.show', [$store->id, $product->id]) }}" class="btn-yellow mt-2">
                                👁️ {{ __('mall.view') }}
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400">{{ __('mall.no_products') }}</p>
                @endforelse
            </div>
        </section>
    </div>

    {{-- 🔥 تفعيل تبويبات بسيطة بالـ JS --}}
    <script>
        document.querySelectorAll('.tab-link').forEach(link => {
            link.addEventListener('click', e => {
                e.preventDefault();
                document.querySelectorAll('.tab-link').forEach(l => l.classList.remove('active'));
                link.classList.add('active');
                const target = link.getAttribute('href');
                document.querySelectorAll('section').forEach(sec => sec.style.display = 'none');
                document.querySelector(target).style.display = 'block';
            });
        });
        // أول تبويب افتراضي
        document.querySelectorAll('section').forEach(sec => sec.style.display = 'none');
        document.querySelector('#stats').style.display = 'block';
    </script>
</x-app-layout>
