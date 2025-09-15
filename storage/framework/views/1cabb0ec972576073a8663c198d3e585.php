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
    <div class="max-w-6xl mx-auto py-10 px-4">

        <!-- 🧭 العنوان -->
        <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">
            🚖🆘 <?php echo e(__('messages.my_orders')); ?>

        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- 🚖 قسم طلبات التاكسي -->
            <div>
                <h2 class="text-xl font-semibold text-yellow-600 mb-4 flex items-center gap-2">
                    🚕 <?php echo e(__('messages.taxi_orders')); ?>

                </h2>

                <?php if($taxiOrders->count()): ?>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $taxiOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-white shadow rounded-lg p-4 border-l-4 border-yellow-500 hover:shadow-md transition">
                                <p class="text-gray-800"><strong><?php echo e(__('messages.status')); ?>:</strong> <?php echo e($order->status); ?></p>
                                <p class="text-gray-700"><strong><?php echo e(__('messages.driver_name')); ?>:</strong> <?php echo e($order->driver_name ?? '—'); ?></p>
                                <p class="text-gray-600 text-sm"><strong><?php echo e(__('messages.created_at')); ?>:</strong> <?php echo e($order->created_at->format('Y-m-d H:i')); ?></p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500 bg-gray-100 p-4 rounded text-center">
                        🔕 <?php echo e(__('messages.no_taxi_orders')); ?>

                    </p>
                <?php endif; ?>
            </div>

            <!-- 🆘 قسم بلاغات الطوارئ -->
            <div>
                <h2 class="text-xl font-semibold text-red-600 mb-4 flex items-center gap-2">
                    🆘 <?php echo e(__('messages.emergency_reports')); ?>

                </h2>

                <?php if($emergencyReports->count()): ?>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $emergencyReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-white shadow rounded-lg p-4 border-l-4 border-red-500 hover:shadow-md transition">
                                <p class="text-gray-800"><strong><?php echo e(__('messages.center_name')); ?>:</strong> <?php echo e($report->center_name); ?></p>
                                <p class="text-gray-700"><strong><?php echo e(__('messages.city')); ?>:</strong> <?php echo e($report->city); ?></p>
                                <p class="text-gray-700"><strong><?php echo e(__('messages.report_status')); ?>:</strong> <?php echo e($report->status ?? __('messages.new_report')); ?></p>
                                <p class="text-gray-600 text-sm"><strong><?php echo e(__('messages.created_at')); ?>:</strong> <?php echo e($report->created_at->format('Y-m-d H:i')); ?></p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500 bg-gray-100 p-4 rounded text-center">
                        🔕 <?php echo e(__('messages.no_emergency_reports')); ?>

                    </p>
                <?php endif; ?>
            </div>
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
<?php /**PATH /home/delni_user/delni/resources/views/dashboard/myorders.blade.php ENDPATH**/ ?>