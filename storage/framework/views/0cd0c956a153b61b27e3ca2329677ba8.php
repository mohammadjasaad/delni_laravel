
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
    <div class="max-w-4xl mx-auto px-4 py-10">
        <h1 class="text-2xl font-bold text-center text-yellow-600 mb-6">
            <?php echo e(__('messages.faq_title')); ?>

        </h1>

        <div class="space-y-6">
            <div>
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-1">❓ <?php echo e(__('messages.faq_q1')); ?></h3>
                <p class="text-gray-600 dark:text-gray-400"><?php echo e(__('messages.faq_a1')); ?></p>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-1">❓ <?php echo e(__('messages.faq_q2')); ?></h3>
                <p class="text-gray-600 dark:text-gray-400"><?php echo e(__('messages.faq_a2')); ?></p>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-1">❓ <?php echo e(__('messages.faq_q3')); ?></h3>
                <p class="text-gray-600 dark:text-gray-400"><?php echo e(__('messages.faq_a3')); ?></p>
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
<?php /**PATH /home/delni_user/delni/resources/views/pages/faq.blade.php ENDPATH**/ ?>