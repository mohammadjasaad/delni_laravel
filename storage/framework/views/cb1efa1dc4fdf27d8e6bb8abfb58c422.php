<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('messages.statistics'))]); ?>
    <div class="max-w-7xl mx-auto px-4 py-10">

        
        <h1 class="text-3xl font-extrabold text-yellow-600 text-center mb-12">
            📊 إحصائيات الموقع
        </h1>

        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-12">
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-6 text-center">
                <div class="text-4xl font-extrabold text-yellow-600"><?php echo e($userCount); ?></div>
                <div class="text-gray-700 mt-3">👤 عدد المستخدمين</div>
            </div>
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-6 text-center">
                <div class="text-4xl font-extrabold text-yellow-600"><?php echo e($adCount); ?></div>
                <div class="text-gray-700 mt-3">📢 عدد الإعلانات</div>
            </div>
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-6 text-center">
                <div class="text-4xl font-extrabold text-yellow-600"><?php echo e($emergencyCount); ?></div>
                <div class="text-gray-700 mt-3">🆘 مراكز الطوارئ</div>
            </div>
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-6 text-center">
                <div class="text-4xl font-extrabold text-yellow-600"><?php echo e($reportCount); ?></div>
                <div class="text-gray-700 mt-3">🚨 عدد البلاغات</div>
            </div>
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-6 text-center">
                <div class="text-4xl font-extrabold text-yellow-600"><?php echo e($driverCount); ?></div>
                <div class="text-gray-700 mt-3">🚖 عدد السائقين</div>
            </div>
        </div>

        
        <div class="bg-white rounded-xl shadow p-6 mb-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3">🏠 أكثر 3 مدن تحتوي إعلانات</h2>
            <ul class="divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $topAdCities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <li class="flex justify-between items-center py-2">
                        <span class="font-medium"><?php echo e($city->city); ?></span>
                        <span class="text-gray-600"><?php echo e($city->total); ?> إعلان</span>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <li class="py-2 text-gray-500">لا توجد بيانات حالياً.</li>
                <?php endif; ?>
            </ul>
        </div>

        
        <div class="bg-white rounded-xl shadow p-6 mb-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3">🚑 أكثر 3 مدن تحتوي مراكز طوارئ</h2>
            <ul class="divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $topEmergencyCities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <li class="flex justify-between items-center py-2">
                        <span class="font-medium"><?php echo e($city->city); ?></span>
                        <span class="text-gray-600"><?php echo e($city->total); ?> مركز</span>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <li class="py-2 text-gray-500">لا توجد بيانات حالياً.</li>
                <?php endif; ?>
            </ul>
        </div>

        
        <div class="bg-gradient-to-r from-yellow-50 to-white rounded-xl shadow p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">🚖 أكثر المدن طلبًا لخدمة Delni Taxi</h2>
            <p class="text-gray-600">
                (🔜 سيتم تنفيذ هذا القسم قريباً مع تطوير خدمة التاكسي 🚕 ليعرض أكثر المدن طلباً بشكل تفاعلي)
            </p>
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
<?php /**PATH /home/delni_user/delni/resources/views/dashboard/statistics.blade.php ENDPATH**/ ?>