@props(['class' => ''])

@php
    $current = app()->getLocale();
    $next = $current === 'ar' ? 'en' : 'ar';
@endphp

<a href="{{ route('lang.switch', $next) }}"
   class="inline-flex items-center gap-2 px-3 py-2 rounded-full bg-gray-100 hover:bg-gray-200 text-sm font-semibold {{ $class }}"
   rel="nofollow" hreflang="{{ $next }}">
    <span class="sr-only">{{ __('messages.language') }}</span>
    {{-- 🌐 أيقونة بسيطة --}}
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
        <path fill-rule="evenodd"
              d="M10 18a8 8 0 100-16 8 8 0 000 16zm6-8a6 6 0 01-5-5.917A6.002 6.002 0 004 10h12zm-6 6a6 6 0 005-5.917H4.083A6.002 6.002 0 0010 16z"
              clip-rule="evenodd"/>
    </svg>
    <span class="font-bold uppercase">{{ $next }}</span>
</a>
