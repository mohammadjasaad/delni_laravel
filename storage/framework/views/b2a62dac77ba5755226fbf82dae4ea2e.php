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
    <div class="max-w-6xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-yellow-600 text-center mb-8">🚨 البلاغات الواردة على مراكز الطوارئ</h1>

        <?php if(session('success')): ?>
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-6 text-center">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if($reports->isEmpty()): ?>
            <p class="text-center text-gray-600">لا توجد بلاغات حالياً.</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-300 bg-white shadow-md">
                    <thead class="bg-yellow-100 text-gray-800">
                        <tr>
                            <th class="py-3 px-4 border">🏷️ اسم المركز</th>
                            <th class="py-3 px-4 border">🏙️ المدينة</th>
                            <th class="py-3 px-4 border">📄 السبب</th>
                            <th class="py-3 px-4 border">📅 تاريخ البلاغ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-100">
                                <td class="py-2 px-4 border font-semibold text-gray-700">
                                    <?php echo e($report->service->name ?? 'غير متوفر'); ?>

                                </td>
                                <td class="py-2 px-4 border text-gray-600">
                                    <?php echo e($report->service->city ?? '-'); ?>

                                </td>
                                <td class="py-2 px-4 border text-gray-800">
                                    <?php echo e($report->reason); ?>

                                </td>
                                <td class="py-2 px-4 border text-gray-500 text-sm">
                                    <?php echo e($report->created_at->format('Y-m-d H:i')); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
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
<?php /**PATH /home/delni_user/delni/resources/views/dashboard/emergency_reports/index.blade.php ENDPATH**/ ?>