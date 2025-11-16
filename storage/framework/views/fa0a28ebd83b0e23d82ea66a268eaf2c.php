<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<div class="max-w-7xl mx-auto px-4 pt-2 pb-8">


<div class="w-full mb-6">
    <div class="relative w-full overflow-hidden rounded-xl shadow-lg">
        <div class="swiper servicesSwiper">
            <div class="swiper-wrapper">
                <?php $__empty_1 = true; $__currentLoopData = $service_banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="swiper-slide">
                        <a href="<?php echo e($banner->link ?? '#'); ?>">
                            <img src="<?php echo e(asset('storage/'.$banner->image_desktop)); ?>"
                                 alt="<?php echo e($banner->title); ?>"
                                 class="w-full h-48 md:h-72 object-cover">
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="swiper-slide">
                        <img src="<?php echo e(asset('images/services_default_banner.jpg')); ?>" class="w-full h-48 md:h-72 object-cover">
                    </div>
                <?php endif; ?>
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
        🛠️ <?php echo e(__('messages.services')); ?>

    </h1>

    <div class="max-w-md mx-auto mb-4">
        <input
            type="text"
            id="serviceSearch"
            placeholder="ابحث عن خدمة... مثل: حلاقة، محامي، تنظيف"
            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-xl shadow-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
        >
    </div>

<?php
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
?>

    <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupTitle => $cards): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <h2 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mb-6"><?php echo e($groupTitle); ?></h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 mb-12">
            <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <a href="<?php echo e(route('services.byType', $card['sub'])); ?>"
                   class="service-card-item flex flex-col items-center p-5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition"
                   data-title="<?php echo e($card['title']); ?>">

                    <div class="w-16 h-16 flex items-center justify-center mb-3">
                        <i class="fa-solid <?php echo e($card['icon']); ?> text-4xl text-yellow-600 dark:text-yellow-400"></i>
                    </div>

                    <div class="text-center text-sm font-medium text-gray-700 dark:text-gray-200"><?php echo e($card['title']); ?></div>

                </a>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div>

<script>
document.getElementById('serviceSearch').addEventListener('input', function () {
    let search = this.value.toLowerCase().trim();
    document.querySelectorAll('.service-card-item').forEach(card => {
        card.style.display = card.dataset.title.toLowerCase().includes(search) ? '' : 'none';
    });
});
</script>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /home/delni_user/delni/resources/views/services/index.blade.php ENDPATH**/ ?>