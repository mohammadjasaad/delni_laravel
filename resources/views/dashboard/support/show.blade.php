{{-- resources/views/dashboard/support/show.blade.php --}}
<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-4">
        
        {{-- 🟡 العنوان --}}
        <h1 class="text-2xl font-bold text-yellow-600 mb-6 text-center">
            🎫 {{ __('messages.support_ticket_details') }}
        </h1>

        {{-- ✅ بطاقة تفاصيل التذكرة --}}
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">
                {{ __('messages.subject') }}: {{ $ticket->subject }}
            </h2>

            <p class="text-gray-700 mb-4 whitespace-pre-line">
                {{ $ticket->message }}
            </p>

            <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                <span>📅 {{ __('messages.created_at') }}: {{ $ticket->created_at->format('Y-m-d H:i') }}</span>
                <span>📌 {{ __('messages.status') }}: 
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        @if($ticket->status === __('messages.ticket_status_new')) bg-blue-100 text-blue-700
                        @elseif($ticket->status === __('messages.ticket_status_processing')) bg-yellow-100 text-yellow-700
                        @elseif($ticket->status === __('messages.ticket_status_answered')) bg-green-100 text-green-700
                        @elseif($ticket->status === __('messages.ticket_status_closed')) bg-gray-200 text-gray-600
                        @endif">
                        {{ $ticket->status }}
                    </span>
                </span>
            </div>
        </div>

        {{-- 💬 قسم الردود --}}
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">
                💬 {{ __('messages.replies') }}
            </h2>

            {{-- ✅ عرض الردود --}}
            @if($ticket->replies->count() > 0)
                <div class="space-y-4 mb-6">
                    @foreach($ticket->replies as $reply)
                        <div class="p-4 rounded-lg border 
                            @if($reply->user_id === auth()->id())
                                bg-yellow-50 text-gray-800 border-yellow-200
                            @elseif($reply->user && $reply->user->role === 'admin')
                                bg-yellow-100 text-gray-900 border-yellow-300
                            @else
                                bg-gray-100 text-gray-700 border-gray-200
                            @endif">
                            
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-semibold text-sm">
                                    👤 {{ $reply->user->name ?? __('messages.unknown_user') }}
                                    @if($reply->user && $reply->user->role === 'admin')
                                        <span class="ml-2 text-xs text-yellow-700 font-bold">({{ __('messages.admin') }})</span>
                                    @elseif($reply->user_id === auth()->id())
                                        <span class="ml-2 text-xs text-yellow-600 font-bold">({{ __('messages.me') }})</span>
                                    @endif
                                </span>
                                <small class="text-gray-500">
                                    📅 {{ $reply->created_at->format('Y-m-d H:i') }}
                                </small>
                            </div>
                            
                            <p class="text-sm whitespace-pre-line">{{ $reply->message }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 mb-6">🔕 {{ __('messages.no_replies') }}</p>
            @endif

            {{-- 📝 نموذج إضافة رد --}}
            @if($ticket->status !== __('messages.ticket_status_closed'))
                <form method="POST" action="{{ route('support.reply', $ticket->id) }}" class="space-y-4">
                    @csrf
                    <textarea name="message" rows="3" required
                        placeholder="{{ __('messages.write_reply') }}"
                        class="w-full border rounded-lg p-3 text-sm"></textarea>

                    <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg shadow">
                        📩 {{ __('messages.send_reply') }}
                    </button>
                </form>
            @else
                <p class="text-center text-gray-500">🚫 {{ __('messages.ticket_closed_message') ?? 'هذه التذكرة مغلقة ولا يمكن الرد عليها.' }}</p>
            @endif
        </div>

        {{-- 🔙 زر العودة --}}
        <div class="text-center">
            <a href="{{ route('support.index') }}" 
               class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg shadow">
                ⬅️ {{ __('messages.back_to_tickets') }}
            </a>
        </div>
    </div>
</x-app-layout>
