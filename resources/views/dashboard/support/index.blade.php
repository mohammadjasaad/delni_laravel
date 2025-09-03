{{-- resources/views/dashboard/support/index.blade.php --}}
<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-4">
        
        {{-- 🟡 العنوان --}}
        <h1 class="text-3xl font-bold text-yellow-600 mb-8 text-center">
            🎫 {{ __('messages.support_tickets') }}
        </h1>

        {{-- ✅ زر إضافة تذكرة جديدة --}}
        <div class="mb-6 text-center">
            <a href="{{ route('support.create') }}" 
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-lg shadow transition font-semibold">
                ➕ {{ __('messages.add_new_ticket') ?? 'Add New Ticket' }}
            </a>
        </div>

        {{-- ✅ جدول عرض التذاكر --}}
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full border border-gray-200 divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">#</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">{{ __('messages.subject') ?? 'Subject' }}</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">{{ __('messages.status') ?? 'Status' }}</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">{{ __('messages.created_at') }}</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($tickets as $ticket)
                        <tr>
                            <td class="px-4 py-2 text-gray-700">#{{ $ticket->id }}</td>
                            <td class="px-4 py-2 text-gray-700">{{ $ticket->subject }}</td>
                            <td class="px-4 py-2">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($ticket->status === 'جديد') bg-blue-100 text-blue-700
                                    @elseif($ticket->status === 'قيد المعالجة') bg-yellow-100 text-yellow-700
                                    @elseif($ticket->status === 'تم الرد') bg-green-100 text-green-700
                                    @elseif($ticket->status === 'مغلق') bg-gray-200 text-gray-600
                                    @endif">
                                    {{ $ticket->status }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-gray-500">{{ $ticket->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('support.show', $ticket->id) }}" 
                                   class="text-yellow-600 hover:underline font-semibold">
                                    {{ __('messages.view_details') }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                                {{ __('messages.no_tickets') ?? 'No tickets found.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
