{{-- resources/views/admin/users.blade.php --}}
<x-app-layout :isAdmin="true">
    <div class="max-w-6xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold text-yellow-600 mb-8 text-center">👥 إدارة المستخدمين</h1>

        {{-- 🔍 فلترة حسب الدور --}}
        <div class="mb-6">
            <form method="GET" class="flex justify-end">
                <select name="role" onchange="this.form.submit()" class="border px-4 py-2 rounded text-sm">
                    <option value="">كل المستخدمين</option>
                    <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>مستخدم عادي</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>مشرف</option>
                </select>
            </form>
        </div>

        {{-- 📋 جدول المستخدمين --}}
        <div class="overflow-x-auto bg-white rounded-xl shadow p-4">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="py-2 px-4">#</th>
                        <th class="py-2 px-4">الاسم</th>
                        <th class="py-2 px-4">البريد</th>
                        <th class="py-2 px-4">الدور</th>
                        <th class="py-2 px-4 text-center">إجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $user)
                        <tr class="border-b">
                            <td class="py-2 px-4">{{ $index + 1 }}</td>
                            <td class="py-2 px-4">{{ $user->name }}</td>
                            <td class="py-2 px-4">{{ $user->email }}</td>
                            <td class="py-2 px-4">{{ $user->role ?? 'user' }}</td>
                            <td class="py-2 px-4 text-center">
                                @if ($user->role !== 'admin')
                                    <form method="POST" action="{{ route('admin.promote', $user->id) }}">
                                        @csrf
                                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                            ترقية لمشرف
                                        </button>
                                    </form>
                                @else
                                    <span class="text-green-600 font-semibold">مشرف</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
