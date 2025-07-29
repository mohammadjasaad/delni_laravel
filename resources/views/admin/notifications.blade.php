<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">🔔 إشعارات المستخدمين</h1>

        @if($notifications->count())
            <ul class="space-y-4">
                @foreach($notifications as $notification)
                    <li class="bg-white border rounded shadow p-4 text-sm text-gray-800">
                        <p>{{ $notification->data['message'] ?? '— إشعار غير معروف —' }}</p>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $notification->created_at->format('Y-m-d H:i') }}
                            | مرسل إلى: {{ optional($notification->notifiable)->email ?? 'غير معروف' }}
                        </p>
                    </li>
                @endforeach
            </ul>

            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @else
            <p class="text-gray-500">لا توجد إشعارات حالياً.</p>
        @endif
    </div>
</x-app-layout>
