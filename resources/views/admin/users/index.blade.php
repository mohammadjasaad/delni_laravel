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
                        <th class="px-4 py-2 text-left text-gray-600 font-semibold">{{ __('messages.name') }}</th>
                        <th class="px-4 py-2 text-left text-gray-600 font-semibold">{{ __('messages.email') }}</th>
                        <th class="px-4 py-2 text-left text-gray-600 font-semibold">{{ __('messages.role') }}</th>
                        <th class="px-4 py-2 text-left text-gray-600 font-semibold">{{ __('messages.registered_since') }}</th>
                        <th class="px-4 py-2 text-center text-gray-600 font-semibold">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr>
                            <td class="px-4 py-2 text-gray-800 font-medium">{{ $user->name }}</td>
                            <td class="px-4 py-2 text-gray-700">{{ $user->email }}</td>
                            <td class="px-4 py-2">
                                @if($user->role === 'admin')
                                    <span class="text-red-600 font-bold">{{ __('messages.admin') }}</span>
                                @else
                                    <span class="text-gray-700">{{ __('messages.user') }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-gray-600">{{ $user->created_at->diffForHumans() }}</td>
                            <td class="px-4 py-2 text-center">
                                @if($user->role !== 'admin')
                                    <form action="{{ route('admin.users.promote', $user->id) }}" 
                                          method="POST" class="inline">
                                        @csrf
                                        <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded shadow text-xs">
                                            ⭐ {{ __('messages.promote_to_admin') }}
                                        </button>
                                    </form>
                                @else
                                    <span class="text-green-600 font-semibold">{{ __('messages.already_admin') }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">
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
</x-app-layout>
