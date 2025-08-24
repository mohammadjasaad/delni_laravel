([
    'route' => null,
    'icon'  => '📌',
    'title' => '—',
    'desc'  => '',
])

@php
    $href = ($route && \Illuminate\Support\Facades\Route::has($route))
        ? route($route)
        : '#';
@endphp

<a href="{{ $href }}" class="block bg-white rounded-xl shadow hover:shadow-lg transition p-5 border border-gray-100">
    <div class="text-3xl mb-2">{{ $icon }}</div>
    <div class="font-bold text-gray-800 mb-1">{{ $title }}</div>
    @if($desc !== '') <div class="text-sm text-gray-600">{{ $desc }}</div> @endif

    @unless($route && \Illuminate\Support\Facades\Route::has($route))
        <div class="mt-3 text-xs text-red-600">⚠️ هذا الرابط غير مُفعّل بعد</div>
    @endunless
</a>
