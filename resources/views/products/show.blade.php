{{-- resources/views/products/show.blade.php --}}
<x-app-layout :title="$product->name">

<div class="max-w-6xl mx-auto px-4 py-10">

    {{-- مسار الصفحات --}}
    <div class="text-sm text-gray-500 mb-4">
        <a href="{{ route('mall.index') }}" class="hover:text-yellow-500">🛍️ دلني مول</a> /
        <a href="{{ route('mall.show', $store->id) }}" class="hover:text-yellow-500">{{ $store->name }}</a> /
        <span class="text-gray-800 dark:text-gray-200">{{ $product->name }}</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

{{-- ✅ صور المنتج (سلايدر مع أسهم) --}}
<div>
    <div class="swiper productSwiper relative rounded-xl overflow-hidden shadow-lg">

        <div class="swiper-wrapper">
            @if(is_array($product->images) && count($product->images) > 0)
                @foreach($product->images as $img)
                    <div class="swiper-slide">
                        <img src="{{ asset('storage/'.$img) }}" class="w-full h-96 object-cover">
                    </div>
                @endforeach
            @else
                <div class="swiper-slide">
                    <img src="{{ asset('images/no-image.png') }}" class="w-full h-96 object-cover">
                </div>
            @endif
        </div>

        {{-- 🔘 نقاط --}}
        <div class="swiper-pagination"></div>

        {{-- ⬅️➡️ أسهم --}}
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>

    </div>
</div>

        {{-- ✅ تفاصيل المنتج --}}
        <div class="space-y-6">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                {{ $product->name }}
            </h1>

            <p class="text-lg text-gray-600 dark:text-gray-300 leading-relaxed">
                {{ $product->description }}
            </p>

            <div class="text-3xl font-bold text-yellow-500">
                💰 {{ number_format($product->price) }} ل.س
            </div>

            {{-- ✅ زر واتساب --}}
            <a href="https://wa.me/?text={{ urlencode('مرحبا، أريد الاستفسار عن المنتج: '.$product->name.' من متجر '.$store->name.' رابط المنتج: '.url()->current()) }}"
               class="w-full flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white py-3 rounded-xl shadow text-lg font-semibold transition">
                📩 تواصل عبر واتساب
            </a>

<form action="{{ route('cart.add', [$store->id, $product->id]) }}" method="POST">
    @csrf
    <button type="submit"
        class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl shadow text-lg font-semibold transition">
        🛒 أضف للسلة
    </button>
</form>
            {{-- ✅ زر زيارة المتجر --}}
            <a href="{{ route('mall.show', $store->id) }}"
               class="w-full flex items-center justify-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-black py-3 rounded-xl shadow text-lg font-semibold transition">
                🏪 زيارة متجر {{ $store->name }}
            </a>

        </div>
    </div>

</div>

{{-- ✅ سوايبر --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

<script>
    new Swiper(".productSwiper", {
        loop: true,
        slidesPerView: 1,
        spaceBetween: 10,
        autoplay: { delay: 3000 },
        pagination: { el: ".swiper-pagination", clickable: true },
        navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
    });
</script>

{{-- ✅ منتجات مشابهة --}}
@if($relatedProducts->count() > 0)
<div class="mt-16">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
        🔥 منتجات مشابهة من نفس المتجر
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        @foreach($relatedProducts as $item)
            @php
                // نحاول جلب الصور من JSON أو من النص العادي
                $images = $item->images;

                // في حال كانت JSON نحولها
                if (is_string($images) && str_starts_with($images, '[')) {
                    $images = json_decode($images, true);
                }

                // إذا ليست مصفوفة نحولها إلى مصفوفة فارغة
                if (!is_array($images)) {
                    $images = [];
                }

                // نأخذ أول صورة صحيحة فقط
                $firstImage = !empty($images) && isset($images[0])
                    ? asset('storage/' . ltrim($images[0], '/'))
                    : asset('images/no-image.png');
            @endphp

            <a href="{{ route('mall.products.show', [$store->id, $item->id]) }}" class="block group">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-lg transition overflow-hidden">

                    <img src="{{ $firstImage }}"
                         alt="{{ $item->name }}"
                         class="w-full h-48 object-cover rounded-t-xl group-hover:opacity-90 transition duration-300">

                    <div class="p-3 space-y-1">
                        <h3 class="font-semibold text-gray-800 dark:text-white truncate">
                            {{ $item->name }}
                        </h3>
                        <div class="text-yellow-600 font-bold">
                            💰 {{ number_format($item->price) }} ل.س
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endif

</x-app-layout>
