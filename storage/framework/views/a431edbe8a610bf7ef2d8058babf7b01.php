
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['route' => '#', 'icon' => '➡️', 'label' => 'رابط', 'color' => 'blue']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['route' => '#', 'icon' => '➡️', 'label' => 'رابط', 'color' => 'blue']); ?>
<?php foreach (array_filter((['route' => '#', 'icon' => '➡️', 'label' => 'رابط', 'color' => 'blue']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $colors = [
        'blue'   => 'bg-blue-500 hover:bg-blue-600',
        'green'  => 'bg-green-500 hover:bg-green-600',
        'red'    => 'bg-red-500 hover:bg-red-600',
        'yellow' => 'bg-yellow-500 hover:bg-yellow-600',
        'purple' => 'bg-purple-500 hover:bg-purple-600',
        'indigo' => 'bg-indigo-500 hover:bg-indigo-600',
    ];
?>

<a href="<?php echo e(route($route)); ?>"
   class="<?php echo e($colors[$color] ?? 'bg-gray-500 hover:bg-gray-600'); ?> text-white font-bold py-6 rounded-xl shadow text-center transition">
   <?php echo e($icon); ?> <?php echo e($label); ?>

</a>
<?php /**PATH /home/delni_user/delni/resources/views/components/admin/quick-link.blade.php ENDPATH**/ ?>