{{-- resources/views/ads/partials/list.blade.php --}}
@forelse($ads as $ad)
@php
    $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
    $hasImage = !empty($images) && isset($images[0]);

    if ($hasImage) {
        $firstImage = asset('storage/' . $images[0]);
    } else {
        if ($ad->category === 'realestate') {
            $firstImage = asset('storage/placeholders/house.jpg');
        } elseif ($ad->category === 'cars') {
            $firstImage = asset('storage/placeholders/car.jpg');
        } else {
            $firstImage = asset('storage/placeholder.png');
        }
    }
@endphp

    <div class="ad-card relative {{ $ad->is_featured ? 'border-yellow-400':'border-gray-200 dark:border-gray-700' }}">
        {{-- ⭐ إعلان مميز --}}
        @if($ad->is_featured)
            <span class="badge-featured"><i class="fas fa-star"></i></span>
        @endif

{{-- 🏷️ نوع العرض (بيع / إيجار) --}}
@php
$dealTypeLabel = match($ad->deal_type) {
    'sale', 'بيع' => ['label' => '🏷️ بيع', 'color' => 'bg-green-500'],
    'rent', 'إيجار', 'lease' => ['label' => '🏠 إيجار', 'color' => 'bg-blue-500'],
    default => null,
};
@endphp

@if($dealTypeLabel)
    <span class="absolute top-2 right-2 {{ $dealTypeLabel['color'] }} text-white text-xs font-bold px-2 py-1 rounded shadow">
        {{ $dealTypeLabel['label'] }}
    </span>
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

        {{-- 🖼️ الصورة --}}
        <a href="{{ route('ads.show', $ad->slug) }}">
<img src="{{ $firstImage }}" class="w-full h-52 object-cover" alt="{{ $ad->title }}">
        </a>

        {{-- 📋 التفاصيل --}}
        <div class="p-4 flex flex-col justify-between flex-1">
            <h2 class="font-bold text-base truncate text-gray-900 dark:text-white mb-1">{{ $ad->title }}</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mb-2">
                <i class="fas fa-map-marker-alt text-red-500"></i> {{ $ad->city }}
            </p>
            {{-- 💰 السعر --}}
            <p class="text-red-600 font-bold text-sm mt-auto">
                @if($ad->currency === 'USD')
                    <i class="fas fa-dollar-sign text-yellow-500"></i>
                    {{ number_format($ad->price, 0) }} $
                @elseif($ad->currency === 'SYP')
                    <span class="text-yellow-500">ل.س</span>
                    {{ number_format($ad->price, 0) }}
                @else
                    <i class="fas fa-coins text-gray-400"></i>
                    {{ number_format($ad->price, 0) }}
                @endif
            </p>
{{-- 👇👇 بدل هذه المقاطع كاملة بهذا الكود 👇👇 --}}

{{-- ⭐ تفاصيل حسب نوع الإعلان --}}
<div class="text-xs text-gray-700 dark:text-gray-300 space-y-1 mb-2">

    {{-- 🛠️ خدمات --}}
@php
$serviceTypes = [
    'maintenance' => 'صيانة عامة',
    'cleaning' => 'تنظيف منازل ومكاتب',
    'moving' => 'نقل أثاث',
    'gardening' => 'تنسيق حدائق',
    'pets' => 'رعاية الحيوانات',

    'car-mechanic' => 'ميكانيك سيارات',
    'car-electric' => 'كهرباء سيارات',
    'car-wash' => 'غسيل سيارات',
    'cargo' => 'نقل بضائع',
    'driver' => 'سائق خاص',

    'private-lessons' => 'دروس خصوصية',
    'programming' => 'كورسات برمجة',
    'languages' => 'تعليم لغات',
    'music' => 'تعليم موسيقى',
    'fitness' => 'تدريب رياضي',

    'dentists' => 'أطباء أسنان',
    'clinics' => 'عيادات وصيدليات',
    'barbers' => 'صالونات حلاقة',
    'beauty' => 'مراكز تجميل',
    'massage' => 'مساج وعلاج طبيعي',

    'lawyers' => 'محاماة',
    'accounting' => 'محاسبة',
    'marketing' => 'تسويق رقمي',
    'design' => 'تصميم وغرافيك',
    'photography' => 'تصوير',

    'university' => 'تسجيل جامعي',
    'translation' => 'ترجمة',
    'research' => 'كتابة أبحاث',
    'documents' => 'تخليص معاملات',
];

$serviceLabel = $serviceTypes[$ad->service_type] ?? 'خدمة';
@endphp

@if($ad->category === 'services' || $ad->category === 'خدمات')
<p><i class="fas fa-tools text-yellow-500"></i> نوع الخدمة: {{ $serviceLabel }}</p>

        @if($ad->provider_name)
            <p><i class="fas fa-user-tag text-blue-500"></i> المزود: {{ $ad->provider_name }}</p>
        @endif
    @endif

    {{-- 🚗 سيارات --}}
    @if($ad->category === 'cars' || $ad->category === 'سيارة')
        @if($ad->car_brand || $ad->car_model)
            <p><i class="fas fa-car text-yellow-500"></i> {{ $ad->car_brand }} - {{ $ad->car_model }}</p>
        @endif
        @if($ad->car_year)
            <p><i class="fas fa-calendar-alt text-gray-400"></i> سنة الصنع: {{ $ad->car_year }}</p>
        @endif
    @endif

    {{-- 🏠 عقارات --}}
    @if($ad->category === 'realestate' || $ad->category === 'عقار')
        @if($ad->rooms)
            <p><i class="fas fa-bed text-yellow-500"></i> {{ $ad->rooms }} غرف</p>
        @endif
        @if($ad->area_total)
            <p><i class="fas fa-ruler-combined text-blue-500"></i> {{ $ad->area_total }} م²</p>
        @endif
    @endif

</div>

{{-- 🔗 زر عرض الإعلان --}}
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
                    btn.querySelector("i").classList.toggle("fas");
                    btn.querySelector("i").classList.toggle("far");
                } else {
                    console.error("❌ خطأ بالطلب:", response.status);
                }
            } catch (err) {
                console.error("⚠️ خطأ:", err);
            }
        });
    });
});
<style>
.ad-card {
    overflow: hidden;
    border-radius: 14px;
    background: white;
    display: flex;
    flex-direction: column;
    transition: box-shadow .3s ease, transform .3s ease;
}

.ad-card:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    transform: translateY(-3px);
}

.ad-card img {
    transition: transform .4s ease;
}

.ad-card:hover img {
    transform: scale(1.06);
}

.btn-yellow {
    background: #FACC15;
    color: #111;
    padding: 8px 0;
    border-radius: 8px;
    font-weight: bold;
    transition: 0.3s;
}

.btn-yellow:hover {
    background: #e3b810;
}

.badge-featured {
    position: absolute;
    top: 10px;
    left: 10px;
    background: #FACC15;
    color: #111;
    font-size: 14px;
    padding: 4px 7px;
    border-radius: 6px;
    box-shadow: 0px 2px 7px rgba(0,0,0,0.15);
}
</style>
</script>
