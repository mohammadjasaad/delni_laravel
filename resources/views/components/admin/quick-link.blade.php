{{-- resources/views/components/admin/quick-link.blade.php --}}
@props(['route' => '#', 'icon' => '➡️', 'label' => 'رابط', 'color' => 'blue'])

@php
    $colors = [
        'blue'   => 'bg-blue-500 hover:bg-blue-600',
        'green'  => 'bg-green-500 hover:bg-green-600',
        'red'    => 'bg-red-500 hover:bg-red-600',
        'yellow' => 'bg-yellow-500 hover:bg-yellow-600',
        'purple' => 'bg-purple-500 hover:bg-purple-600',
        'indigo' => 'bg-indigo-500 hover:bg-indigo-600',
    ];
@endphp

<a href="{{ route($route) }}"
   class="{{ $colors[$color] ?? 'bg-gray-500 hover:bg-gray-600' }} text-white font-bold py-6 rounded-xl shadow text-center transition">
   {{ $icon }} {{ $label }}
</a>
