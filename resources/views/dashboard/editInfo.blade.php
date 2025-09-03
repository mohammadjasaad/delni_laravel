{{-- resources/views/dashboard/editInfo.blade.php --}}
<x-app-layout>
<div class="max-w-4xl mx-auto px-4 py-8">

    {{-- 🟡 العنوان --}}
    <h1 class="text-3xl font-bold text-gray-800 mb-8">
        <i class="fas fa-user-edit text-blue-500"></i> {{ __('messages.edit_info') }}
    </h1>

    {{-- 📝 نموذج تعديل البيانات --}}
    <form method="POST" action="{{ route('dashboard.myinfo.update') }}" class="bg-white rounded-xl shadow p-6 space-y-6">
        @csrf

        {{-- 👤 الاسم --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-user text-blue-500"></i> {{ __('messages.username') }}
            </label>
            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" 
                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-400">
        </div>

        {{-- 📧 البريد الإلكتروني --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-envelope text-green-500"></i> {{ __('messages.email') }}
            </label>
            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" 
                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-400">
        </div>

        {{-- 🔘 أزرار --}}
        <div class="flex gap-3 mt-6">
            <button type="submit" 
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg shadow">
                <i class="fas fa-save"></i> {{ __('messages.save_changes') }}
            </button>
            <a href="{{ route('dashboard.myinfo') }}" 
               class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg shadow">
                <i class="fas fa-arrow-left"></i> {{ __('messages.back') }}
            </a>
        </div>
    </form>
</div>

{{-- ✅ FontAwesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</x-app-layout>
