{{-- resources/views/components/admin/latest-list.blade.php --}}
@props([
    'title' => '📜 قائمة',
    'items' => [],
    'empty' => __('messages.no_data'),
    'route' => null,        {{-- 🔗 Route لعرض الكل --}}
    'viewRoute' => null,    {{-- 🔗 Route لزر عرض العنصر --}}
    'viewText' => __('messages.view_details'), {{-- 👁️ عرض مترجم افتراضي --}}
])

<div class="mt-12">
    <h2 class="text-xl font-bold text-gray-800 mb-4">{{ $title }}</h2>
    <div class="bg-white shadow rounded-lg p-4">
        <ul class="divide-y divide-gray-200">
            @forelse($items as $item)
                <li class="py-3 flex justify-between items-center">
                    <span class="text-gray-700">
                        @if(isset($item->title))
                            {{ $item->title }}
                        @elseif(isset($item->subject))
                            #{{ $item->id }} - {{ $item->subject }}
                        @elseif(isset($item->ip))
                            {{ $item->ip }} - {{ $item->page }}
                        @else
                            {{ $item->id ?? $item }}
                        @endif
                    </span>

                    @if($viewRoute && isset($item->id))
                        <a href="{{ route($viewRoute, $item->id) }}"
                           class="text-sm text-yellow-600 hover:underline">
                            {{ $viewText }}
                        </a>
                    @endif
                </li>
            @empty
                <li class="py-3 text-gray-500">{{ $empty }}</li>
            @endforelse
        </ul>

        @if($route)
            <div class="text-center mt-4">
                <a href="{{ route($route) }}" class="text-sm text-blue-600 hover:underline">
                    ➕ {{ __('messages.view_all') }}
                </a>
            </div>
        @endif
    </div>
</div>
