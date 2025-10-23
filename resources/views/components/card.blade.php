{{-- resources/views/components/card.blade.php --}}
@props([
    'title' => '',
    'image' => null,
    'description' => '',
    'price' => null,
    'url' => '#',
    'extra' => null,  {{-- نص إضافي مثل المدينة / التصنيف --}}
    'footer' => null, {{-- أزرار --}}
])

<div class="bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-xl transition overflow-hidden border border-gray-200 dark:border-gray-700 flex flex-col">
    
    {{-- صورة --}}
    <a href="{{ $url }}">
        <img src="{{ $image ? asset('storage/'.$image) : asset('images/no-image.png') }}"
             alt="{{ $title }}"
             class="w-full h-40 object-cover">
    </a>

    {{-- محتوى --}}
    <div class="p-4 flex-1 flex flex-col justify-between space-y-3">
        <div>
            <h2 class="text-lg font-bold text-gray-800 dark:text-white truncate">
                {{ $title }}
            </h2>
            @if($description)
                <p class="text-gray-500 dark:text-gray-400 text-sm line-clamp-2">
                    {{ $description }}
                </p>
            @endif
            @if($extra)
                <p class="text-xs text-gray-400 dark:text-gray-500">
                    {{ $extra }}
                </p>
            @endif
        </div>

        {{-- السعر --}}
        @if($price)
            <span class="text-yellow-500 font-bold">{{ $price }} {{ __('messages.currency') }}</span>
        @endif

        {{-- فوتر (أزرار) --}}
        @if($footer)
            <div class="flex items-center justify-between mt-3">
                {!! $footer !!}
            </div>
        @endif
    </div>
</div>
