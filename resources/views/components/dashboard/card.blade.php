@props([
    'route', 
    'icon' => '📌', 
    'title' => 'عنوان البطاقة', 
    'desc' => 'وصف مختصر',
    'color' => 'yellow' // ✅ اللون الافتراضي
])

@php
    // 🎨 ألوان Tailwind حسب الـ prop
    $colors = [
        'yellow' => 'bg-yellow-100 group-hover:bg-yellow-200 text-yellow-600',
        'blue'   => 'bg-blue-100 group-hover:bg-blue-200 text-blue-600',
        'green'  => 'bg-green-100 group-hover:bg-green-200 text-green-600',
        'red'    => 'bg-red-100 group-hover:bg-red-200 text-red-600',
        'purple' => 'bg-purple-100 group-hover:bg-purple-200 text-purple-600',
        'pink'   => 'bg-pink-100 group-hover:bg-pink-200 text-pink-600',
        'gray'   => 'bg-gray-200 group-hover:bg-gray-300 text-gray-700',
    ];

    $iconColor = $colors[$color] ?? $colors['yellow'];

    // ✅ حماية في حال كان الـ route غير معرّف
    $link = \Illuminate\Support\Facades\Route::has($route) ? route($route) : '#';
@endphp

<a href="{{ $link }}" 
   class="group block bg-white rounded-xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1 p-6 border border-gray-100">

    <!-- 🖼️ الأيقونة -->
    <div class="flex items-center justify-center w-14 h-14 rounded-full text-3xl mb-4 transition {{ $iconColor }}">
        {{ $icon }}
    </div>

    <!-- 📝 العنوان -->
    <h3 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-{{ $color }}-600 transition">
        {{ $title }}
    </h3>

    <!-- 📖 الوصف -->
    <p class="text-sm text-gray-600 leading-relaxed">
        {{ $desc }}
    </p>
</a>
