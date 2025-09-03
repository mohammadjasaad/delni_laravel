{{-- resources/views/components/ad-card.blade.php --}}
@props(['ad', 'dashboard' => false]) 
{{-- 🟡 إذا dashboard=true → يظهر أزرار تعديل/حذف --}}

@php
    $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
    $firstImage = $images[0] ?? 'placeholder.png';
@endphp

<div class="relative bg-white rounded-xl shadow hover:shadow-2xl overflow-hidden transition duration-300 border {{ $ad->is_featured ? 'border-yellow-400' : 'border-gray-200' }}">
    
    {{-- ⭐ إعلان مميز --}}
    @if($ad->is_featured)
        <span class="absolute top-2 left-2 bg-yellow-400 text-black text-xs font-bold px-2 py-1 rounded">
            ⭐ {{ __('messages.featured') }}
        </span>
    @endif

    {{-- 🖼️ الصورة --}}
    <a href="{{ route('ads.show', $ad->id) }}">
        <img src="{{ asset('storage/' . $firstImage) }}" 
             class="w-full h-40 object-cover rounded-t-xl" alt="ad">
    </a>

    {{-- 📄 التفاصيل --}}
    <div class="p-4">
        <h2 class="font-bold text-base truncate text-gray-900">{{ $ad->title }}</h2>
        <p class="text-gray-500 text-sm">📍 {{ $ad->city }}</p>
        <p class="text-red-600 font-bold text-sm mt-1">💰 {{ number_format($ad->price) }} {{ __('messages.currency') }}</p>

        {{-- ✅ الوضع العادي (زر عرض الإعلان) --}}
        @unless($dashboard)
            <a href="{{ route('ads.show', $ad->id) }}" 
               class="block mt-3 text-center bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 rounded-lg transition">
                {{ __('messages.view_ad') }}
            </a>
        @endunless

        {{-- ✅ وضع لوحة التحكم (أزرار تعديل/حذف) --}}
        @if($dashboard)
            <div class="flex justify-between mt-3">
                <a href="{{ route('dashboard.ads.edit', $ad->id) }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                    ✏️ {{ __('messages.edit') }}
                </a>
                <form action="{{ route('dashboard.ads.destroy', $ad->id) }}" 
                      method="POST" onsubmit="return confirm('{{ __('messages.confirm_delete') }}');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                        🗑️ {{ __('messages.delete') }}
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>

