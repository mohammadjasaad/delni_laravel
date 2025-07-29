<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['disabled' => false, 'type' => 'text']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['disabled' => false, 'type' => 'text']); ?>
<?php foreach (array_filter((['disabled' => false, 'type' => 'text']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<input 
    <?php echo e($disabled ? 'disabled' : ''); ?> 
    type="<?php echo e($type); ?>" 
    <?php echo e($attributes->merge(['class' => 'border-gray-300 focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50 rounded-md shadow-sm'])); ?> 
/>
<?php /**PATH /home/delni_user/delni/resources/views/components/input.blade.php ENDPATH**/ ?>