{{-- resources/views/components/ad-card.blade.php --}}
@props(['ad', 'dashboard' => false])

@php
    $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
    $firstImage = $images[0] ?? 'placeholder.png';
@endphp

<div class="relative bg-white rounded-xl shadow hover:shadow-lg overflow-hidden transition border 
            {{ $ad->is_featured ? 'border-yellow-400' : 'border-gray-200' }}">

    {{-- ⭐ إعلان مميز --}}
    @if($ad->is_featured)
        <span class="absolute top-2 left-2 bg-yellow-400 text-black text-xs font-bold px-2 py-1 rounded-full">
            ⭐ إعلان مميز
        </span>
    @endif

    {{-- 🖼️ صورة الإعلان --}}
    <a href="{{ route('ads.show', $ad->slug) }}">
        <img src="{{ asset('storage/' . $firstImage) }}"
             class="w-full h-44 object-cover group-hover:scale-105 transition duration-300"
             alt="{{ $ad->title }}">
    </a>

    <div class="p-3 space-y-1">

        {{-- العنوان --}}
        <h3 class="font-bold text-gray-900 text-sm truncate">
            {{ $ad->title }}
        </h3>

        {{-- المدينة --}}
        <p class="text-xs text-gray-500 flex items-center gap-1">
            <i class="fas fa-map-marker-alt text-red-500"></i> {{ $ad->city }}
        </p>

        {{-- السعر --}}
        <p class="text-lg font-extrabold text-yellow-600">
            {{ number_format($ad->price) }} {{ $ad->currency === 'USD' ? '$' : 'ل.س' }}
        </p>

        {{-- ✅ زر عرض الإعلان --}}
        @unless($dashboard)
            <a href="{{ route('ads.show', $ad->slug) }}"
               class="block text-center bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-2 rounded-md text-sm">
                👁️ عرض الإعلان
            </a>
        @endunless

        {{-- ✅ إذا داخل لوحة التحكم --}}
        @if($dashboard)
            <div class="flex justify-between mt-3">
                <a href="{{ route('dashboard.ads.edit', $ad->id) }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs">
                    ✏️ تعديل
                </a>
                <form action="{{ route('dashboard.ads.destroy', $ad->id) }}"
                      method="POST" onsubmit="return confirm('هل أنت متأكد؟');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                        🗑️ حذف
                    </button>
                </form>
            </div>
        @endif

    </div>
</div>
