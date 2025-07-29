@props(['route', 'title', 'desc', 'icon'])

<a href="{{ route($route) }}" class="block bg-white rounded-lg shadow hover:shadow-lg transition p-6 text-center border border-gray-200">
    <div class="text-4xl mb-3">{{ $icon }}</div>
    <div class="text-lg font-bold text-gray-800 mb-1">{{ $title }}</div>
    <div class="text-sm text-gray-500">{{ $desc }}</div>
</a>
