{{-- resources/views/dashboard/edit-password.blade.php --}}
<x-app-layout>
    <div class="max-w-xl mx-auto py-10 px-4">

        <!-- 🧭 العنوان -->
        <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-gray-100 mb-8 flex items-center justify-center gap-2">
            <i class="fas fa-lock text-yellow-500"></i> {{ __('messages.change_password') }}
        </h2>

        {{-- ✅ إشعار النجاح --}}
        @if (session('success'))
            <div class="bg-green-100 dark:bg-green-800 border border-green-400 dark:border-green-600 
                        text-green-800 dark:text-green-100 px-4 py-3 rounded-lg mb-6 text-center shadow">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        {{-- ✅ إشعار الأخطاء --}}
        @if ($errors->any())
            <div class="bg-red-100 dark:bg-red-800 border border-red-400 dark:border-red-600 
                        text-red-700 dark:text-red-100 px-4 py-3 rounded-lg mb-6 shadow">
                <ul class="list-disc pl-5 space-y-1 text-sm text-start">
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-exclamation-triangle"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ✅ نموذج تغيير كلمة المرور --}}
        <form method="POST" action="{{ route('dashboard.password.update') }}" 
              class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg space-y-6">
            @csrf
            @method('PUT')

            {{-- كلمة المرور الحالية --}}
            <div>
                <x-label for="current_password" :value="__('messages.current_password')" 
                         class="text-gray-700 dark:text-gray-200" />
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fas fa-key"></i>
                    </span>
                    <x-input id="current_password" type="password" name="current_password" required
                             autocomplete="current-password"
                             class="pl-10 block w-full dark:bg-gray-700 dark:text-white" />
                </div>
            </div>

            {{-- كلمة المرور الجديدة --}}
            <div>
                <x-label for="new_password" :value="__('messages.new_password')" 
                         class="text-gray-700 dark:text-gray-200" />
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fas fa-lock"></i>
                    </span>
                    <x-input id="new_password" type="password" name="new_password" required
                             autocomplete="new-password"
                             class="pl-10 block w-full dark:bg-gray-700 dark:text-white" />
                </div>
            </div>

            {{-- تأكيد كلمة المرور الجديدة --}}
            <div>
                <x-label for="new_password_confirmation" :value="__('messages.confirm_new_password')" 
                         class="text-gray-700 dark:text-gray-200" />
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fas fa-check"></i>
                    </span>
                    <x-input id="new_password_confirmation" type="password" name="new_password_confirmation" required
                             class="pl-10 block w-full dark:bg-gray-700 dark:text-white" />
                </div>
            </div>

            {{-- زر الحفظ --}}
            <div>
                <x-button class="w-full justify-center bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 rounded-lg shadow transition transform hover:scale-105">
                    <i class="fas fa-save"></i> {{ __('messages.save_changes') }}
                </x-button>
            </div>
        </form>
    </div>

    {{-- ✅ FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</x-app-layout>
