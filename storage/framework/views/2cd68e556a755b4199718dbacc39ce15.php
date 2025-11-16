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
<div class="max-w-7xl mx-auto px-4 py-8">

    <h1 class="text-2xl font-extrabold text-yellow-600 mb-6 flex items-center gap-2">
        <i class="fas fa-tools"></i> <?php echo e($service_type); ?>

    </h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $images = is_array($service->images) ? $service->images : json_decode($service->images, true);
                $firstImage = !empty($images[0]) ? asset('storage/'.$images[0]) : asset('storage/placeholder.png');

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
                    'photography' => 'تصوير ومونتاج',

                    'university' => 'تسجيل جامعي',
                    'translation' => 'ترجمة',
                    'research' => 'كتابة أبحاث',
                    'documents' => 'تخليص معاملات',
                ];

                $serviceLabel = $serviceTypes[$service->service_type] ?? 'خدمة';
            ?>

            <div class="bg-white rounded-2xl shadow hover:shadow-xl transition overflow-hidden">

                
                <a href="<?php echo e(route('ads.show', $service->slug)); ?>">
                    <img src="<?php echo e($firstImage); ?>" class="w-full h-48 object-cover" alt="<?php echo e($service->title); ?>">
                </a>

                <div class="p-4 space-y-2">

                    
                    <h3 class="font-bold text-gray-800 text-base truncate">
                        <?php echo e($service->title); ?>

                    </h3>

                    
                    <p class="text-sm text-yellow-600 font-semibold flex items-center gap-1">
                        <i class="fas fa-tools"></i> <?php echo e($serviceLabel); ?>

                    </p>

                    
                    <?php if($service->provider_name): ?>
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-user-tie text-blue-500"></i> <?php echo e($service->provider_name); ?>

                        </p>
                    <?php endif; ?>

                    
                    <p class="text-sm text-gray-500 flex items-center gap-1">
                        <i class="fas fa-map-marker-alt text-red-500"></i> <?php echo e($service->city); ?>

                    </p>

                    
                    <p class="text-red-600 font-bold text-sm">
                        <?php echo e(number_format($service->price)); ?> 
                        <?php echo e($service->currency == 'USD' ? '$' : 'ل.س'); ?>

                    </p>

                    
                    <a href="<?php echo e(route('ads.show', $service->slug)); ?>"
                       class="block w-full text-center bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 rounded-lg transition">
                        👁️ عرض التفاصيل
                    </a>

                </div>

            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

            <p class="col-span-4 text-center text-gray-500 py-10">
                لا توجد خدمات متاحة حالياً.
            </p>

        <?php endif; ?>

    </div>

    <div class="mt-6">
        <?php echo e($services->links()); ?>

    </div>

</div>
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
<?php /**PATH /home/delni_user/delni/resources/views/services/list.blade.php ENDPATH**/ ?>