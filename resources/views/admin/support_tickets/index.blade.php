{{-- resources/views/admin/support_tickets/index.blade.php --}}
<x-app-layout :isAdmin="true">
    <div class="max-w-7xl mx-auto py-10 px-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">🎫 إدارة تذاكر الدعم الفني</h1>

        {{-- ✅ رسالة نجاح --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        {{-- ✅ جدول التذاكر --}}
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full text-sm text-gray-800">
                <thead class="bg-gray-100 text-gray-600 font-semibold text-right">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">المستخدم</th>
                        <th class="px-4 py-3">الموضوع</th>
                        <th class="px-4 py-3">الحالة</th>
                        <th class="px-4 py-3">التاريخ</th>
                        <th class="px-4 py-3">التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $ticket->id }}</td>
                            <td class="px-4 py-3">{{ $ticket->user->name ?? 'غير معروف' }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $ticket->subject }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-white text-xs font-bold
                                    {{ $ticket->status === 'جديد' ? 'bg-yellow-500' : 
                                       ($ticket->status === 'قيد المعالجة' ? 'bg-blue-500' : 
                                       ($ticket->status === 'تم الرد' ? 'bg-green-500' : 'bg-gray-500')) }}">
                                    {{ $ticket->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                {{ $ticket->created_at->translatedFormat('Y/m/d - h:i A') }}
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.support_tickets.show', $ticket->id) }}"
                                   class="text-indigo-600 hover:underline font-semibold">👁️ عرض</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6 text-gray-500">لا توجد تذاكر دعم حتى الآن.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
