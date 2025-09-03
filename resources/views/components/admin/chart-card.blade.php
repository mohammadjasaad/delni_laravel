@props([
    'id',
    'title',
    'labels' => [],
    'data' => [],
    'borderColor' => '#3b82f6', // الأزرق الافتراضي
    'bgColor' => '#93c5fd',     // السماوي الافتراضي
])

@php
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
@endphp

<div class="bg-white p-6 rounded-xl shadow">
    <h2 class="text-lg font-bold text-gray-800 mb-4">{{ $title }}</h2>
    <canvas 
        id="{{ $id }}" 
        height="100"
        data-chart='@json($chartConfig)'>
    </canvas>
</div>
