<div class="max-w-7xl mx-auto px-4 mt-4">
@php
    // نوع الرسالة => لون Tailwind
    $levels = [
        'success' => 'green',
        'error'   => 'red',
        'warning' => 'yellow',
        'info'    => 'blue',
    ];
@endphp

@foreach($levels as $key => $color)
    @if(session($key))
        <div x-data="{ show: true }"
             x-init="setTimeout(() => show = false, 4000)"
             x-show="show" x-transition
             class="relative mb-3 rounded-md border-l-4 border-{{ $color }}-500 bg-{{ $color }}-50 p-3 text-{{ $color }}-700">
            {{ session($key) }}
            <button type="button" @click="show = false"
                    class="absolute top-2 end-2 text-{{ $color }}-700/70 hover:text-{{ $color }}-700">✖</button>
        </div>
    @endif
@endforeach

@if(session('status') === 'logged-out')
    <div x-data="{ show: true }"
         x-init="setTimeout(() => show = false, 4000)"
         x-show="show" x-transition
         class="relative mb-3 rounded-md border-l-4 border-green-500 bg-green-50 p-3 text-green-700">
        ✅ تم تسجيل الخروج بنجاح
        <button type="button" @click="show = false"
                class="absolute top-2 end-2 text-green-700/70 hover:text-green-700">✖</button>
    </div>
@endif
</div>
