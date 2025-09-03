{{-- resources/views/admin/notifications/index.blade.php --}}
<x-app-layout :isAdmin="true">
    <div class="max-w-7xl mx-auto py-10 px-4">

        {{-- 🟡 العنوان --}}
        <h1 class="text-3xl font-bold text-yellow-600 mb-8 text-center">
            🔔 {{ __('messages.notifications') }}
        </h1>

        {{-- ✅ جدول الإشعارات --}}
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full border border-gray-200 divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-gray-600 font-semibold">#</th>
                        <th class="px-4 py-2 text-left text-gray-600 font-semibold">{{ __('messages.title') }}</th>
                        <th class="px-4 py-2 text-left text-gray-600 font-semibold">{{ __('messages.message') }}</th>
                        <th class="px-4 py-2 text-left text-gray-600 font-semibold">{{ __('messages.date') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($notifications as $index => $notification)
                        <tr>
                            <td class="px-4 py-2 text-gray-700">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 text-gray-800 font-medium">
                                {{ $notification->title ?? '—' }}
                            </td>
                            <td class="px-4 py-2 text-gray-700">
                                {{ $notification->message ?? '—' }}
                            </td>
                            <td class="px-4 py-2 text-gray-600">
                                {{ $notification->created_at->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                                {{ __('messages.no_notifications') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ✅ روابط التصفح --}}
        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    </div>
</x-app-layout>
