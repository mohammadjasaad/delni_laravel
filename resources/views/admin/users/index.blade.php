{{-- resources/views/admin/users/index.blade.php --}}
<x-app-layout :isAdmin="true">
    <div class="max-w-7xl mx-auto py-10 px-4">
        
        {{-- 🟡 العنوان --}}
        <h1 class="text-3xl font-bold text-yellow-600 mb-8 text-center">
            👥 {{ __('messages.manage_users') }}
        </h1>

        {{-- ✅ فلترة حسب الدور --}}
        <div class="mb-6 flex justify-end">
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-2">
                <select name="role" onchange="this.form.submit()" 
                        class="border-gray-300 rounded-lg shadow-sm px-3 py-2 text-sm">
                    <option value="">{{ __('messages.all') }}</option>
                    <option value="user" @if(request('role')==='user') selected @endif>
                        {{ __('messages.user') }}
                    </option>
                    <option value="admin" @if(request('role')==='admin') selected @endif>
                        {{ __('messages.admin') }}
                    </option>
                </select>
            </form>
        </div>

        {{-- ✅ جدول المستخدمين --}}
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full border border-gray-200 divide-y divide-gray-200 text-sm">
<thead class="bg-gray-50">
    <tr>
        <th class="px-4 py-2 text-left text-gray-600 font-semibold">الاسم</th>
        <th class="px-4 py-2 text-left text-gray-600 font-semibold">الإيميل</th>
        <th class="px-4 py-2 text-left text-gray-600 font-semibold">الدور</th>
        <th class="px-4 py-2 text-center text-gray-600 font-semibold">عدد الإعلانات</th> {{-- 🆕 --}}
        <th class="px-4 py-2 text-left text-gray-600 font-semibold">الحالة</th>
        <th class="px-4 py-2 text-left text-gray-600 font-semibold">مسجل منذ</th>
        <th class="px-4 py-2 text-center text-gray-600 font-semibold">إجراءات</th>
    </tr>
</thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr>
                            <td class="px-4 py-2 text-gray-800 font-medium">{{ $user->name }}</td>
                            <td class="px-4 py-2 text-gray-700">{{ $user->email }}</td>

                            {{-- 🎭 الدور --}}
                            <td class="px-4 py-2">
                                @if($user->role === 'admin')
                                    <span class="text-red-600 font-bold">{{ __('messages.admin') }}</span>
                                @else
                                    <span class="text-gray-700">{{ __('messages.user') }}</span>
                                @endif
                            </td>
{{-- 📊 عدد الإعلانات --}}
<td class="px-4 py-2 text-center">
    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-semibold">
        {{ $user->ads_count }} إعلان
    </span>
</td>
                            {{-- 🟢 حالة الاتصال --}}
                            <td class="px-4 py-2">
                                @if($user->isOnline())
                                    <span class="text-green-600 font-semibold">🟢 متصل الآن</span>
                                @else
                                    <span class="text-gray-500 text-xs">
                                        ⏱ آخر ظهور: {{ $user->last_seen ? $user->last_seen->diffForHumans() : '—' }}
                                    </span>
                                @endif
                            </td>

                            {{-- ⏱ مسجل منذ --}}
                            <td class="px-4 py-2 text-gray-600">{{ $user->created_at->diffForHumans() }}</td>

{{-- ⭐ ترقية / 🚫 حظر --}}
<td class="px-4 py-2 text-center space-x-1">

    {{-- ⭐ زر الترقية للمشرف --}}
    @if($user->role !== 'admin')
        <form action="{{ route('admin.users.promote', $user->id) }}" method="POST" class="inline">
            @csrf
            <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded shadow text-xs">
                ⭐ ترقية
            </button>
        </form>
    @endif

<td class="px-4 py-2 text-center flex items-center gap-1 justify-center">

    {{-- 🚫 / 🔓 زر الحظر / إلغاء الحظر --}}
    <form action="{{ route('admin.users.toggleBan', $user->id) }}" method="POST" class="inline ban-form">
        @csrf
        @if($user->banned_at)
            <button type="button" class="unban-btn bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded shadow text-xs flex items-center gap-1">
                🔓 إلغاء الحظر
            </button>
        @else
            <button type="button" class="ban-btn bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded shadow text-xs flex items-center gap-1">
                🚫 حظر
            </button>
        @endif
    </form>


</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                {{ __('messages.no_users_found') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ✅ روابط التصفح --}}
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // زر الحظر
    document.querySelectorAll('.ban-btn').forEach(button => {
        button.addEventListener('click', function () {
            if (confirm('⚠️ هل تريد حظر هذا المستخدم؟')) {
                this.closest('form').submit();
            }
        });
    });

    // زر إلغاء الحظر
    document.querySelectorAll('.unban-btn').forEach(button => {
        button.addEventListener('click', function () {
            if (confirm('✅ هل تريد إلغاء الحظر عن هذا المستخدم؟')) {
                this.closest('form').submit();
            }
        });
    });

});
</script>
</x-app-layout>
