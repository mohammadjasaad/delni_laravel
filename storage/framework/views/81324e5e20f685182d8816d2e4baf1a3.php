
<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['isAdmin' => true]); ?>
    <div class="max-w-7xl mx-auto py-10 px-4">
        
        
        <h1 class="text-3xl font-bold text-yellow-600 mb-8 text-center">
            👥 <?php echo e(__('messages.visitors')); ?>

        </h1>

        
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full border border-gray-200 divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600"><?php echo e(__('messages.ip')); ?> 🖥️</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600"><?php echo e(__('messages.page')); ?> 📄</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600"><?php echo e(__('messages.user_agent')); ?> 🌐</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600"><?php echo e(__('messages.visited_at')); ?> ⏰</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $visitors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visitor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="px-4 py-2 text-gray-700"><?php echo e($visitor->ip); ?></td>
                            <td class="px-4 py-2 text-gray-700"><?php echo e($visitor->page); ?></td>
                            <td class="px-4 py-2 text-gray-500 truncate max-w-[200px]"><?php echo e($visitor->user_agent ?? '—'); ?></td>
                            <td class="px-4 py-2 text-gray-700">
                                <?php echo e($visitor->visited_at ? $visitor->visited_at->format('Y-m-d H:i') : '—'); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                                <?php echo e(__('messages.no_visitors')); ?>

                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <div class="mt-6">
            <?php echo e($visitors->links()); ?>

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
<?php /**PATH /home/delni_user/delni/resources/views/admin/visitors/index.blade.php ENDPATH**/ ?>