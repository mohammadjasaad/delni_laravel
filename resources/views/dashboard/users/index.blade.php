<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-8">

        {{-- ✅ العنوان --}}
        <h1 class="text-3xl font-bold text-center text-yellow-600 mb-8">👥 إدارة المستخدمين</h1>

        {{-- ✅ رسالة نجاح --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-6 text-center">
                {{ session('success') }}
            </div>
        @endif
{{-- ✅ نموذج البحث مع فلتر الدور --}}
<form method="GET" action="{{ route('dashboard.users.index') }}" class="mb-6 flex flex-col sm:flex-row justify-center items-center gap-2">
    <input type="text" name="search" value="{{ request('search') }}"
        class="border border-gray-300 rounded px-4 py-2 w-72 focus:outline-none"
        placeholder="🔍 ابحث بالاسم أو البريد الإلكتروني...">

    <select name="role" class="border border-gray-300 rounded px-4 py-2 focus:outline-none">
        <option value="">الكل</option>
        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>مستخدم</option>
        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>مشرف</option>
    </select>

    <button type="submit"
        class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
        🔎 بحث
    </button>
</form>
        {{-- ✅ جدول المستخدمين --}}
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full text-sm text-gray-800 border border-gray-200">
                <thead class="bg-yellow-100 text-center">
                    <tr>
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">👤 الاسم</th>
                        <th class="px-4 py-2 border">📧 البريد الإلكتروني</th>
                        <th class="px-4 py-2 border">🛡️ الدور</th>
                        <th class="px-4 py-2 border">📅 التسجيل</th>
                        <th class="px-4 py-2 border">⚙️ خيارات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-50 text-center">
                            <td class="px-4 py-2 border">{{ $user->id }}</td>
                            <td class="px-4 py-2 border text-start">{{ $user->name }}</td>
                            <td class="px-4 py-2 border text-start">{{ $user->email }}</td>
                            <td class="px-4 py-2 border">
                                @if ($user->role === 'admin')
                                    <span class="text-red-600 font-semibold">مشرف</span>
                                @else
                                    <span class="text-gray-600">مستخدم</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 border">{{ $user->created_at->format('Y-m-d') }}</td>
                            <td class="px-4 py-2 border">
                                @if ($user->role !== 'admin')
                                    <form method="POST" action="{{ route('dashboard.users.makeAdmin', $user->id) }}">
                                        @csrf
                                        <button type="submit"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-1 rounded text-sm">
                                            👑 ترقية إلى مشرف
                                        </button>
                                    </form>
                                @else
                                    <span class="text-green-600 font-semibold">✔️ مشرف</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
