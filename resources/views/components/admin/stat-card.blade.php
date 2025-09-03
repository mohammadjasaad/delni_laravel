{{-- resources/views/components/admin/stat-card.blade.php --}}
@props(['icon' => '📊', 'label' => 'العنوان', 'value' => 0, 'color' => 'blue'])

@php
    $colors = [
        'blue'   => 'text-blue-600',
        'green'  => 'text-green-600',
        'red'    => 'text-red-600',
        'yellow' => 'text-yellow-600',
        'purple' => 'text-purple-600',
        'orange' => 'text-orange-600',
        'indigo' => 'text-indigo-600',
    ];
@endphp

<div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition text-center">
    <h2 class="text-lg font-bold text-gray-700">{{ $icon }} {{ $label }}</h2>
    <p class="text-3xl font-extrabold {{ $colors[$color] ?? 'text-gray-600' }}">
        {{ $value }}
    </p>
</div>
