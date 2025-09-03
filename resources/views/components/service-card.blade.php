@props([
    'icon' => '🛠️',
    'title' => 'خدمة',
    'desc' => 'وصف مختصر',
    'link' => '#'
])

<a href="{{ $link }}" class="block bg-white rounded-xl shadow hover:shadow-lg p-5 transition cursor-pointer">
    <div class="text-3xl mb-3">{{ $icon }}</div>
    <h3 class="font-bold text-lg text-gray-800 mb-2">{{ $title }}</h3>
    <p class="text-gray-500 text-sm">{{ $desc }}</p>
</a>
