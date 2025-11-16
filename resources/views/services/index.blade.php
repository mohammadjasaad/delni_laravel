<x-app-layout>
<div class="max-w-7xl mx-auto px-4 pt-2 pb-8">

{{-- ✅ سلايدر صفحة الخدمات --}}
<div class="w-full mb-6">
    <div class="relative w-full overflow-hidden rounded-xl shadow-lg">
        <div class="swiper servicesSwiper">
            <div class="swiper-wrapper">
                @forelse($service_banners as $banner)
                    <div class="swiper-slide">
                        <a href="{{ $banner->link ?? '#' }}">
                            <img src="{{ asset('storage/'.$banner->image_desktop) }}"
                                 alt="{{ $banner->title }}"
                                 class="w-full h-48 md:h-72 object-cover">
                        </a>
                    </div>
                @empty
                    <div class="swiper-slide">
                        <img src="{{ asset('images/services_default_banner.jpg') }}" class="w-full h-48 md:h-72 object-cover">
                    </div>
                @endforelse
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
  new Swiper(".servicesSwiper", {
    pagination: { el: ".swiper-pagination", clickable: true },
    autoplay: { delay: 4000 },
    loop: true,
  });
</script>

    <h1 class="text-4xl font-extrabold text-center text-gray-800 dark:text-gray-100 mb-4">
        🛠️ {{ __('messages.services') }}
    </h1>

    <div class="max-w-md mx-auto mb-4">
        <input
            type="text"
            id="serviceSearch"
            placeholder="ابحث عن خدمة... مثل: حلاقة، محامي، تنظيف"
            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-xl shadow-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
        >
    </div>

@php
$groups = [
    '🏠 خدمات منزلية' => [
        ['title' => 'تنظيف منازل ومكاتب', 'sub' => 'cleaning', 'icon' => 'fa-broom'],
        ['title' => 'صيانة عامة', 'sub' => 'maintenance', 'icon' => 'fa-screwdriver-wrench'],
        ['title' => 'نقل أثاث', 'sub' => 'moving', 'icon' => 'fa-truck-moving'],
        ['title' => 'تنسيق حدائق', 'sub' => 'gardening', 'icon' => 'fa-leaf'],
        ['title' => 'رعاية الحيوانات', 'sub' => 'pets', 'icon' => 'fa-paw'],
    ],

    '🚗 خدمات سيارات' => [
        ['title' => 'ميكانيك سيارات', 'sub' => 'car-mechanic', 'icon' => 'fa-engine-warning'],
        ['title' => 'كهرباء سيارات', 'sub' => 'car-electric', 'icon' => 'fa-bolt'],
        ['title' => 'غسيل سيارات', 'sub' => 'car-wash', 'icon' => 'fa-car-side'],
        ['title' => 'نقل بضائع', 'sub' => 'cargo', 'icon' => 'fa-truck'],
        ['title' => 'سائق خاص', 'sub' => 'driver', 'icon' => 'fa-id-card'],
    ],

    '🎓 تعليم وتدريب' => [
        ['title' => 'دروس خصوصية', 'sub' => 'private-lessons', 'icon' => 'fa-chalkboard-user'],
        ['title' => 'كورسات برمجة', 'sub' => 'programming', 'icon' => 'fa-code'],
        ['title' => 'تعليم لغات', 'sub' => 'languages', 'icon' => 'fa-language'],
        ['title' => 'تعليم موسيقى', 'sub' => 'music', 'icon' => 'fa-guitar'],
        ['title' => 'تدريب رياضي', 'sub' => 'fitness', 'icon' => 'fa-dumbbell'],
    ],

    '💅 صحة وتجميل' => [
        ['title' => 'أطباء أسنان', 'sub' => 'dentists', 'icon' => 'fa-tooth'],
        ['title' => 'عيادات وصيدليات', 'sub' => 'clinics', 'icon' => 'fa-hospital'],
        ['title' => 'صالونات حلاقة', 'sub' => 'barbers', 'icon' => 'fa-scissors'],
        ['title' => 'مراكز تجميل', 'sub' => 'beauty', 'icon' => 'fa-spa'],
        ['title' => 'مساج وعلاج طبيعي', 'sub' => 'massage', 'icon' => 'fa-hand-sparkles'],
    ],

    '📈 أعمال وخدمات' => [
        ['title' => 'محاماة', 'sub' => 'lawyers', 'icon' => 'fa-scale-balanced'],
        ['title' => 'محاسبة', 'sub' => 'accounting', 'icon' => 'fa-calculator'],
        ['title' => 'تسويق رقمي', 'sub' => 'marketing', 'icon' => 'fa-bullhorn'],
        ['title' => 'تصميم وغرافيك', 'sub' => 'design', 'icon' => 'fa-pen-nib'],
        ['title' => 'تصوير ومونتاج', 'sub' => 'photography', 'icon' => 'fa-camera'],
    ],
];
@endphp

    @foreach($groups as $groupTitle => $cards)
        <h2 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mb-6">{{ $groupTitle }}</h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 mb-12">
            @foreach($cards as $card)

                <a href="{{ route('services.byType', $card['sub']) }}"
                   class="service-card-item flex flex-col items-center p-5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition"
                   data-title="{{ $card['title'] }}">

                    <div class="w-16 h-16 flex items-center justify-center mb-3">
                        <i class="fa-solid {{ $card['icon'] }} text-4xl text-yellow-600 dark:text-yellow-400"></i>
                    </div>

                    <div class="text-center text-sm font-medium text-gray-700 dark:text-gray-200">{{ $card['title'] }}</div>

                </a>

            @endforeach
        </div>
    @endforeach

</div>

<script>
document.getElementById('serviceSearch').addEventListener('input', function () {
    let search = this.value.toLowerCase().trim();
    document.querySelectorAll('.service-card-item').forEach(card => {
        card.style.display = card.dataset.title.toLowerCase().includes(search) ? '' : 'none';
    });
});
</script>

</x-app-layout>
