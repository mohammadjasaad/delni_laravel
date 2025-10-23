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

{{-- ✅ زر إظهار/إخفاء التصنيفات --}}
<div class="text-center mb-6">
    <button id="toggleMallCategories" 
            class="px-6 py-2 bg-yellow-400 text-black rounded-full font-semibold hover:bg-yellow-500 transition">
<i class="fas fa-th-large"></i> {{ __('messages.mall_categories') }}
    </button>
</div>

{{-- ✅ التصنيفات (مخفية افتراضياً) --}}
<div id="mallCategories" class="hidden flex flex-wrap items-center justify-center gap-3 mb-6">
    <a href="#" class="px-5 py-2 rounded-full text-sm font-semibold transition
       bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
        <i class="fas fa-laptop"></i> {{ __('mall.electronics') }}
    </a>

    <a href="#" class="px-5 py-2 rounded-full text-sm font-semibold transition
       bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
        <i class="fas fa-plug"></i> {{ __('mall.electricals') }}
    </a>

    <a href="#" class="px-5 py-2 rounded-full text-sm font-semibold transition
       bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
        <i class="fas fa-tshirt"></i> {{ __('mall.fashion') }}
    </a>

    <a href="#" class="px-5 py-2 rounded-full text-sm font-semibold transition
       bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
        <i class="fas fa-couch"></i> {{ __('mall.furniture') }}
    </a>

    <a href="#" class="px-5 py-2 rounded-full text-sm font-semibold transition
       bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
        <i class="fas fa-car"></i> {{ __('mall.cars') }}
    </a>

    <a href="#" class="px-5 py-2 rounded-full text-sm font-semibold transition
       bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
        <i class="fas fa-magic"></i> {{ __('mall.beauty') }}
    </a>

    <a href="#" class="px-5 py-2 rounded-full text-sm font-semibold transition
       bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
        <i class="fas fa-spray-can"></i> {{ __('mall.perfumes') }}
    </a>

    <a href="#" class="px-5 py-2 rounded-full text-sm font-semibold transition
       bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
        <i class="fas fa-book"></i> {{ __('mall.books') }}
    </a>

    <a href="#" class="px-5 py-2 rounded-full text-sm font-semibold transition
       bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
        <i class="fas fa-puzzle-piece"></i> {{ __('mall.toys') }}
    </a>

    <a href="#" class="px-5 py-2 rounded-full text-sm font-semibold transition
       bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
        <i class="fas fa-blender"></i> {{ __('mall.home_tools') }}
    </a>

    <a href="#" class="px-5 py-2 rounded-full text-sm font-semibold transition
       bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
        <i class="fas fa-shopping-basket"></i> {{ __('mall.supermarket') }}
    </a>

    <a href="#" class="px-5 py-2 rounded-full text-sm font-semibold transition
       bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
        <i class="fas fa-industry"></i> {{ __('mall.industrial') }}
    </a>

    <a href="#" class="px-5 py-2 rounded-full text-sm font-semibold transition
       bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
        <i class="fas fa-hard-hat"></i> {{ __('mall.construction') }}
    </a>
</div>

<script>
  document.getElementById("toggleMallCategories").addEventListener("click", function() {
    document.getElementById("mallCategories").classList.toggle("hidden");
  });
</script>

        {{-- ✅ أقسام المتاجر (Grid) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($stores as $store)
                <div class="store-card">
                    <a href="{{ route('mall.show', $store->id) }}">
                        <img src="{{ $store->logo ? asset('storage/'.$store->logo) : asset('storage/placeholder.png') }}"
                             alt="{{ $store->name }}">
                        <h3>{{ $store->name }}</h3>
                        <p>{{ Str::limit($store->description, 60) }}</p>
                    </a>
                </div>
            @endforeach
        </div>

        {{-- ✅ Pagination --}}
        <div class="mt-6">
            {{ $stores->links() }}
        </div>

    </div>
</x-app-layout>
