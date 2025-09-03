
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['icon' => '📊', 'label' => 'العنوان', 'value' => 0, 'color' => 'blue']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['icon' => '📊', 'label' => 'العنوان', 'value' => 0, 'color' => 'blue']); ?>
<?php foreach (array_filter((['icon' => '📊', 'label' => 'العنوان', 'value' => 0, 'color' => 'blue']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $colors = [
        'blue'   => 'text-blue-600',
        'green'  => 'text-green-600',
        'red'    => 'text-red-600',
        'yellow' => 'text-yellow-600',
        'purple' => 'text-purple-600',
        'orange' => 'text-orange-600',
        'indigo' => 'text-indigo-600',
    ];
?>

<div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition text-center">
    <h2 class="text-lg font-bold text-gray-700"><?php echo e($icon); ?> <?php echo e($label); ?></h2>
    <p class="text-3xl font-extrabold <?php echo e($colors[$color] ?? 'text-gray-600'); ?>">
        <?php echo e($value); ?>

    </p>
</div>
<?php /**PATH /home/delni_user/delni/resources/views/components/admin/stat-card.blade.php ENDPATH**/ ?>