{{-- resources/views/admin/visitors/index.blade.php --}}
<x-app-layout :isAdmin="true">
    <div class="max-w-7xl mx-auto py-10 px-4">
        
        {{-- 🟡 العنوان --}}
        <h1 class="text-3xl font-bold text-yellow-600 mb-8 text-center">
            👥 {{ __('messages.visitors') }}
        </h1>

        {{-- ✅ جدول عرض الزوار --}}
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full border border-gray-200 divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">{{ __('messages.ip') }} 🖥️</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">{{ __('messages.page') }} 📄</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">{{ __('messages.user_agent') }} 🌐</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">{{ __('messages.visited_at') }} ⏰</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($visitors as $visitor)
                        <tr>
                            <td class="px-4 py-2 text-gray-700">{{ $visitor->ip }}</td>
                            <td class="px-4 py-2 text-gray-700">{{ $visitor->page }}</td>
                            <td class="px-4 py-2 text-gray-500 truncate max-w-[200px]">{{ $visitor->user_agent ?? '—' }}</td>
                            <td class="px-4 py-2 text-gray-700">
                                {{ $visitor->visited_at ? $visitor->visited_at->format('Y-m-d H:i') : '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                                {{ __('messages.no_visitors') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ✅ روابط التصفح (Pagination) --}}
        <div class="mt-6">
            {{ $visitors->links() }}
        </div>
    </div>
</x-app-layout>
