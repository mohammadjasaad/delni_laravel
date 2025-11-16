{{-- resources/views/mall/index.blade.php --}}
<x-app-layout :title="__('mall.title')">

    <div class="max-w-7xl mx-auto px-4 py-0 space-y-10">
{{-- ✅ سلايدر دلني مول --}}
<div class="w-full mb-2">
    <div class="relative w-full overflow-hidden rounded-xl shadow-lg">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @if(isset($banners) && $banners->count())
                    @foreach($banners as $banner)
                        <div class="swiper-slide">
                            <a href="{{ $banner->link ?? '#' }}">
                                <img src="{{ asset('storage/'.$banner->image_desktop) }}"
                                     alt="{{ $banner->title }}"
                                     class="w-full h-48 md:h-72 object-cover">
                            </a>
                        </div>
                    @endforeach
                @else
                    {{-- ✅ fallback صور افتراضية --}}
                    <div class="swiper-slide">
                        <img src="{{ asset('images/banner1.jpg') }}" alt="Banner 1" class="w-full h-48 md:h-72 object-cover">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('images/banner2.jpg') }}" alt="Banner 2" class="w-full h-48 md:h-72 object-cover">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('images/banner3.jpg') }}" alt="Banner 3" class="w-full h-48 md:h-72 object-cover">
                    </div>
                @endif
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>

{{-- ✅ مكتبة Swiper --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
  new Swiper(".mySwiper", {
    pagination: { el: ".swiper-pagination", clickable: true },
    autoplay: { delay: 4000 },
    loop: true,
  });
</script>

        {{-- 🛍️ عنوان الصفحة --}}
<h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-6 text-center">
    🛍️ {{ __('messages.delni_mall') }}
</h1>

{{-- ✅ زر إدارة المتجر أو إنشاء متجر جديد --}}
{{-- ✅ أزرار (أضف متجر + أقسام دلني مول) جنب بعض --}}
<div class="flex justify-center gap-3 mb-8">

    @if(auth()->check())
        @if(auth()->user()->store)
            <a href="{{ route('mall.dashboard', auth()->user()->store->id) }}"
               class="flex items-center gap-2 px-5 py-2 bg-yellow-400 hover:bg-yellow-500 text-black rounded-full font-semibold shadow transition">
                🏪 متجري
            </a>
        @else
            <a href="{{ route('mall.create') }}"
               class="flex items-center gap-2 px-5 py-2 bg-yellow-400 hover:bg-yellow-500 text-black rounded-full font-semibold shadow transition">
                ➕ أضف متجر
            </a>
        @endif
    @endif

    <button id="toggleMallCategories"
        class="flex items-center gap-2 px-5 py-2 bg-yellow-400 hover:bg-yellow-500 text-black rounded-full font-semibold shadow transition">
        <i class="fas fa-th-large"></i> {{ __('messages.mall_categories') }}
    </button>

</div>

{{-- ✅ التصنيفات (مخفية افتراضياً) --}}
@php
    $currentCategory = request('category');
    $categories = config('mall.categories');
@endphp

<div id="mallCategories" class="hidden flex flex-wrap items-center justify-center gap-3 mb-6">
@foreach($categories as $key => $label)
    <a href="{{ route('mall.index', ['category' => $key]) }}"
       class="px-5 py-2 rounded-full text-sm font-semibold transition
       {{ $currentCategory == $key
            ? 'bg-yellow-400 text-black shadow'
            : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600'
       }}">
        {{ $label }}
    </a>
@endforeach
</div>

<script>
  document.getElementById("toggleMallCategories").addEventListener("click", function() {
    document.getElementById("mallCategories").classList.toggle("hidden");
  });
</script>

{{-- 🏪 عرض المتاجر --}}
<h2 class="text-2xl font-bold text-gray-800 dark:text-white text-center mb-6">
    🏪 المتاجر {{ $category ? 'في قسم: ' . $categories[$category] : '' }}
</h2>

<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 pb-10">
    @forelse($stores as $store)
        <a href="{{ route('mall.show', $store->id) }}" 
           class="block group rounded-2xl overflow-hidden bg-white dark:bg-gray-800 shadow-sm hover:shadow-xl transition">

<img src="{{ $store->logo ? asset('storage/'.$store->logo) : asset('images/no-image.png') }}"
     alt="{{ $store->name }}"
     class="w-full h-40 object-cover rounded-xl shadow bg-gray-100">

            <div class="p-3">
                <h3 class="font-semibold text-gray-800 dark:text-white group-hover:text-yellow-500 transition">
                    {{ $store->name }}
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ Str::limit($store->description, 45) }}</p>
            </div>
        </a>
    @empty
        <p class="text-gray-500 text-center col-span-full">لا توجد متاجر في هذا القسم.</p>
    @endforelse
</div>

{{ $stores->links() }}

{{-- 🛍️ منتجات من نفس القسم --}}
@if(isset($products) && $products->count())
<h2 class="text-2xl font-bold text-gray-800 dark:text-white text-center mt-10 mb-6">
    🛍️ منتجات من نفس القسم
</h2>

<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 pb-20">
    @foreach($products as $product)
        <a href="{{ route('mall.products.show', ['store' => $product->store_id, 'product' => $product->id]) }}" 
           class="block group rounded-2xl overflow-hidden bg-white dark:bg-gray-800 shadow-sm hover:shadow-xl transition">

@php
    // ✅ تحويل الصور من JSON إلى مصفوفة في حال كانت نص
    $images = $product->images;

    if (is_string($images) && str_starts_with($images, '[')) {
        $images = json_decode($images, true);
    }

    if (!is_array($images)) {
        $images = [];
    }

    // ✅ اختيار أول صورة متاحة
    $firstImage = !empty($images) && isset($images[0])
        ? asset('storage/' . ltrim($images[0], '/'))
        : asset('images/no-image.png');
@endphp

<img src="{{ $firstImage }}"
     alt="{{ $product->name }}"
     class="w-full h-48 object-cover rounded-t-xl group-hover:scale-105 transition duration-300">

            <div class="p-3">
                <h3 class="font-semibold text-gray-800 dark:text-white group-hover:text-yellow-500 transition truncate">
                    {{ $product->name }}
                </h3>
                <p class="text-sm font-bold text-yellow-600 dark:text-yellow-400 mt-1">
                    {{ number_format($product->price) }} ل.س
                </p>
            </div>
        </a>
    @endforeach
</div>
@endif

    {{-- ✅ Pagination --}}
    <div class="max-w-7xl mx-auto px-4">
        {{ $stores->links() }}
    </div>

</x-app-layout>
