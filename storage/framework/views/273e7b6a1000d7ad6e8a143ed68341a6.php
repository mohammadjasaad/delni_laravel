<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['route', 'title', 'desc', 'icon']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['route', 'title', 'desc', 'icon']); ?>
<?php foreach (array_filter((['route', 'title', 'desc', 'icon']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<a href="<?php echo e(route($route)); ?>" class="block bg-white rounded-lg shadow hover:shadow-lg transition p-6 text-center border border-gray-200">
    <div class="text-4xl mb-3"><?php echo e($icon); ?></div>
    <div class="text-lg font-bold text-gray-800 mb-1"><?php echo e($title); ?></div>
    <div class="text-sm text-gray-500"><?php echo e($desc); ?></div>
</a>
<?php /**PATH /home/delni_user/delni/resources/views/components/dashboard/card.blade.php ENDPATH**/ ?>