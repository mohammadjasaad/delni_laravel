{{-- resources/views/dashboard/notifications.blade.php --}}
<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-4">

        {{-- 🧭 العنوان --}}
        <h1 class="text-2xl font-extrabold text-gray-900 mb-8 text-center">
            🔔 {{ __('messages.my_notifications') }}
        </h1>

        @if($notifications->count() > 0)
            {{-- زر تمييز الكل كمقروء --}}
            <form action="{{ route('dashboard.notifications.markAllRead') }}" method="POST" class="mb-6 text-center">
                @csrf
                <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg shadow">
                    ✅ {{ __('messages.mark_all_read') }}
                </button>
            </form>

            <div class="space-y-4">
                @foreach($notifications as $notification)
                    <div class="bg-white border rounded-lg p-5 shadow hover:shadow-md transition">
                        <div class="flex justify-between items-center">
                            <div class="flex flex-col">
                                {{-- نص الإشعار --}}
                                <span class="text-sm text-gray-800 {{ $notification->read_at ? 'opacity-60' : 'font-bold' }}">
                                    {{ $notification->data['message'] ?? __('messages.no_notifications') }}
                                </span>

                                {{-- رابط التذكرة إذا كان موجود --}}
                                @if(isset($notification->data['ticket_id']))
                                    <a href="{{ route('support.show', $notification->data['ticket_id']) }}" 
                                       class="text-xs text-yellow-600 hover:underline mt-1">
                                        ➡️ {{ __('messages.view_details') }}
                                    </a>
                                @endif
                            </div>

                            <div class="flex items-center gap-3">
                                {{-- وقت الإشعار --}}
                                <span class="text-xs text-gray-400">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>

                                {{-- زر تمييز كمقروء --}}
                                @if(!$notification->read_at)
                                    <form action="{{ route('dashboard.notifications.markRead', $notification->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-xs bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">
                                            {{ __('messages.mark_read') }}
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ✅ روابط التصفح --}}
            <div class="mt-8">
                {{ $notifications->links('pagination::tailwind') }}
            </div>
        @else
            <div class="p-6 bg-gray-100 text-gray-500 rounded-lg text-center">
                🔕 {{ __('messages.no_notifications') }}
            </div>
        @endif

        {{-- 🔙 زر العودة --}}
        <div class="mt-8 text-center">
            <a href="{{ route('dashboard.index') }}" 
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-lg shadow transition">
                ⬅️ {{ __('messages.back_to_dashboard') }}
            </a>
        </div>
    </div>
</x-app-layout>
