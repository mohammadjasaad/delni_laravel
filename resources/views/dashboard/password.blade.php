{{-- resources/views/dashboard/password.blade.php --}}
<x-app-layout>
<div class="max-w-4xl mx-auto px-4 py-8">

    {{-- 🟡 العنوان --}}
    <h1 class="text-3xl font-bold text-gray-800 mb-8">
        <i class="fas fa-key text-yellow-500"></i> {{ __('messages.change_password') }}
    </h1>

    {{-- 📝 نموذج تغيير كلمة المرور --}}
    <form method="POST" action="{{ route('dashboard.password.update') }}" 
          class="bg-white rounded-xl shadow p-6 space-y-6">
        @csrf

        {{-- 🔑 كلمة المرور الحالية --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-lock text-gray-500"></i> {{ __('messages.current_password') }}
            </label>
            <input type="password" name="current_password" required
                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-gray-400">
        </div>

        {{-- 🔑 كلمة المرور الجديدة --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-lock-open text-green-500"></i> {{ __('messages.new_password') }}
            </label>
            <input type="password" name="password" required
                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-400">
        </div>

        {{-- 🔑 تأكيد كلمة المرور الجديدة --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-check text-blue-500"></i> {{ __('messages.confirm_password') }}
            </label>
            <input type="password" name="password_confirmation" required
                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-400">
        </div>

        {{-- 🔘 أزرار --}}
        <div class="flex gap-3 mt-6">
            <button type="submit" 
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg shadow">
                <i class="fas fa-save"></i> {{ __('messages.save_changes') }}
            </button>
            <a href="{{ route('dashboard.index') }}" 
               class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg shadow">
                <i class="fas fa-arrow-left"></i> {{ __('messages.back') }}
            </a>
        </div>
    </form>
</div>

{{-- ✅ FontAwesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</x-app-layout>
