{{-- resources/views/ads/partials/list.blade.php --}}
@forelse($ads as $ad)
    @php
        $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
        $firstImage = !empty($images[0]) ? asset('storage/'.$images[0]) : asset('storage/placeholder.png');
    @endphp

    <div class="ad-card relative {{ $ad->is_featured ? 'border-yellow-400':'border-gray-200 dark:border-gray-700' }}">
        {{-- ⭐ إعلان مميز --}}
        @if($ad->is_featured)
            <span class="badge-featured"><i class="fas fa-star"></i></span>
        @endif

        {{-- ❤️ زر المفضلة --}}
        <div class="absolute top-2 left-2 z-10">
            @auth
                <button 
                    class="favorite-btn {{ auth()->user()->favorites->contains($ad->id) ? 'text-red-600' : 'text-gray-400' }} hover:text-red-600 transition"
                    data-slug="{{ $ad->slug }}">
                    <i class="{{ auth()->user()->favorites->contains($ad->id) ? 'fas' : 'far' }} fa-heart fa-lg"></i>
                </button>
            @endauth
        </div>

        {{-- صورة الإعلان --}}
        <a href="{{ route('ads.show', $ad->slug) }}">
            <img src="{{ $firstImage }}" class="w-full h-48 object-cover rounded-t-xl" alt="ad">
        </a>

        {{-- تفاصيل الإعلان --}}
        <div class="p-4 flex flex-col justify-between flex-1">
            <h2 class="font-bold text-base truncate text-gray-900 dark:text-white">{{ $ad->title }}</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm">
                <i class="fas fa-map-marker-alt text-red-500"></i> {{ $ad->city }}
            </p>
            <p class="text-red-600 font-bold text-sm mt-1">
                <i class="fas fa-dollar-sign"></i> {{ number_format($ad->price) }} {{ __('messages.currency') }}
            </p>
            <a href="{{ route('ads.show', $ad->slug) }}" class="block mt-3 text-center btn-yellow">
                <i class="fas fa-eye"></i> {{ __('messages.view_ad') }}
            </a>
        </div>
    </div>
@empty
    <p class="text-center col-span-4 text-gray-500 mt-8">
        <i class="fas fa-exclamation-circle"></i> {{ __('messages.no_ads_found') }}
    </p>
@endforelse


{{-- ✅ سكربت التحكم بالمفضلة --}}
<script>
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".favorite-btn").forEach(btn => {
        btn.addEventListener("click", async (e) => {
            e.preventDefault();

            const slug = btn.dataset.slug;
            const token = document.querySelector('meta[name="csrf-token"]').content;

            try {
                let response = await fetch(`/ads/${slug}/toggle-favorite`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": token,
                        "Accept": "application/json",
                    }
                });

                if (response.ok) {
                    btn.classList.toggle("text-red-600");
                    btn.classList.toggle("text-gray-400");

                    let icon = btn.querySelector("i");
                    icon.classList.toggle("fas");
                    icon.classList.toggle("far");
                } else {
                    console.error("❌ خطأ بالطلب:", response.status);
                }
            } catch (err) {
                console.error("⚠️ خطأ:", err);
            }
        });
    });
});
</script>
