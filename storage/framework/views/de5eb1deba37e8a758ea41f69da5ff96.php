<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'for',
    'value' => '',
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'for',
    'value' => '',
]); ?>
<?php foreach (array_filter(([
    'for',
    'value' => '',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<label for="<?php echo e($for); ?>" <?php echo e($attributes->merge(['class' => 'block font-medium text-sm text-gray-700'])); ?>>
    <?php echo e($value ?: $slot); ?>

</label>
<?php /**PATH /home/delni_user/delni/resources/views/components/label.blade.php ENDPATH**/ ?>