
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'title' => '📜 قائمة',
    'items' => [],
    'empty' => __('messages.no_data'),
    'route' => null,        
    'viewRoute' => null,    
    'viewText' => __('messages.view_details'), 
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'title' => '📜 قائمة',
    'items' => [],
    'empty' => __('messages.no_data'),
    'route' => null,        
    'viewRoute' => null,    
    'viewText' => __('messages.view_details'), 
]); ?>
<?php foreach (array_filter(([
    'title' => '📜 قائمة',
    'items' => [],
    'empty' => __('messages.no_data'),
    'route' => null,        
    'viewRoute' => null,    
    'viewText' => __('messages.view_details'), 
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div class="mt-12">
    <h2 class="text-xl font-bold text-gray-800 mb-4"><?php echo e($title); ?></h2>
    <div class="bg-white shadow rounded-lg p-4">
        <ul class="divide-y divide-gray-200">
            <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li class="py-3 flex justify-between items-center">
                    <span class="text-gray-700">
                        <?php if(isset($item->title)): ?>
                            <?php echo e($item->title); ?>

                        <?php elseif(isset($item->subject)): ?>
                            #<?php echo e($item->id); ?> - <?php echo e($item->subject); ?>

                        <?php elseif(isset($item->ip)): ?>
                            <?php echo e($item->ip); ?> - <?php echo e($item->page); ?>

                        <?php else: ?>
                            <?php echo e($item->id ?? $item); ?>

                        <?php endif; ?>
                    </span>

                    <?php if($viewRoute && isset($item->id)): ?>
                        <a href="<?php echo e(route($viewRoute, $item->id)); ?>"
                           class="text-sm text-yellow-600 hover:underline">
                            <?php echo e($viewText); ?>

                        </a>
                    <?php endif; ?>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li class="py-3 text-gray-500"><?php echo e($empty); ?></li>
            <?php endif; ?>
        </ul>

        <?php if($route): ?>
            <div class="text-center mt-4">
                <a href="<?php echo e(route($route)); ?>" class="text-sm text-blue-600 hover:underline">
                    ➕ <?php echo e(__('messages.view_all')); ?>

                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH /home/delni_user/delni/resources/views/components/admin/latest-list.blade.php ENDPATH**/ ?>