<x-app-layout>
    <div class="max-w-xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">🔐 {{ __('messages.change_password') }}</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('dashboard.password.update') }}" class="space-y-4">
            @csrf

            <!-- كلمة المرور الحالية -->
            <div>
                <x-label for="current_password" :value="__('messages.current_password')" />
                <x-input id="current_password" type="password" name="current_password" required
                         class="block mt-1 w-full" />
                @error('current_password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- كلمة المرور الجديدة -->
            <div>
                <x-label for="new_password" :value="__('messages.new_password')" />
                <x-input id="new_password" type="password" name="new_password" required
                         class="block mt-1 w-full" />
            </div>

            <!-- تأكيد كلمة المرور -->
            <div>
                <x-label for="new_password_confirmation" :value="__('messages.confirm_password')" />
                <x-input id="new_password_confirmation" type="password" name="new_password_confirmation" required
                         class="block mt-1 w-full" />
            </div>

            <div class="pt-4">
                <x-primary-button>
                    🔒 {{ __('messages.update_password') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
