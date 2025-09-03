{{-- resources/views/admin/notifications.blade.php --}}
<x-app-layout :isAdmin="true">
    <div class="max-w-6xl mx-auto py-10 px-4">

        {{-- 🧭 العنوان + زر "تحديد الكل كمقروء" --}}
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-extrabold text-yellow-600">
                🔔 {{ __('messages.admin_notifications') }}
            </h1>
            @if($notifications->count() > 0)
                <form method="POST" action="{{ route('admin.notifications.markAllAsRead') }}">
                    @csrf
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow text-sm">
                        ✅ {{ __('messages.mark_all_as_read') }}
                    </button>
                </form>
            @endif
        </div>

        @if($notifications->count() > 0)
            <div class="space-y-4">
                @foreach($notifications as $notification)
                    <div class="bg-white border rounded-lg p-5 shadow hover:shadow-md transition flex justify-between items-center">
                        <div class="flex flex-col">
                            {{-- نص الإشعار --}}
                            <span class="text-sm text-gray-800">
                                {{ $notification->data['message'] ?? __('messages.no_notifications') }}
                            </span>

                            {{-- رابط التذكرة إذا كان إشعار متعلق بالدعم الفني --}}
                            @if(isset($notification->data['ticket_id']))
                                <a href="{{ route('admin.support_tickets.show', $notification->data['ticket_id']) }}" 
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

                            {{-- زر "تحديد كمقروء" --}}
                            @if(is_null($notification->read_at))
                                <form method="POST" action="{{ route('admin.notifications.markAsRead', $notification->id) }}">
                                    @csrf
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs">
                                        👁️ {{ __('messages.mark_as_read') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ✅ روابط التصفح (Pagination) --}}
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
            <a href="{{ route('admin.dashboard') }}" 
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-lg shadow transition">
                ⬅️ {{ __('messages.back_to_dashboard') }}
            </a>
        </div>
    </div>
</x-app-layout>
