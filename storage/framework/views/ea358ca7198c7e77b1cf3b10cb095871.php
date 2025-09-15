<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'id',
    'title',
    'labels' => [],
    'data' => [],
    'borderColor' => '#3b82f6', // الأزرق الافتراضي
    'bgColor' => '#93c5fd',     // السماوي الافتراضي
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'id',
    'title',
    'labels' => [],
    'data' => [],
    'borderColor' => '#3b82f6', // الأزرق الافتراضي
    'bgColor' => '#93c5fd',     // السماوي الافتراضي
]); ?>
<?php foreach (array_filter(([
    'id',
    'title',
    'labels' => [],
    'data' => [],
    'borderColor' => '#3b82f6', // الأزرق الافتراضي
    'bgColor' => '#93c5fd',     // السماوي الافتراضي
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $chartConfig = [
        "type" => "line",
        "data" => [
            "labels" => $labels,
            "datasets" => [[
                "label" => $title,
                "data" => $data,
                "borderColor" => $borderColor,
                "backgroundColor" => $bgColor,
                "fill" => true,
                "tension" => 0.4
            ]]
        ],
        "options" => [
            "responsive" => true,
            "plugins" => [
                "legend" => ["display" => false]
            ],
            "scales" => [
                "y" => ["beginAtZero" => true]
            ]
        ]
    ];
?>

<div class="bg-white p-6 rounded-xl shadow">
    <h2 class="text-lg font-bold text-gray-800 mb-4"><?php echo e($title); ?></h2>
    <canvas 
        id="<?php echo e($id); ?>" 
        height="100"
        data-chart='<?php echo json_encode($chartConfig, 15, 512) ?>'>
    </canvas>
</div>
<?php /**PATH /home/delni_user/delni/resources/views/components/admin/chart-card.blade.php ENDPATH**/ ?>