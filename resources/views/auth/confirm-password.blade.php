<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
        <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6">

            <h1 class="text-2xl font-bold text-center text-yellow-600 mb-6">
                {{ __('messages.confirm_password') }}
            </h1>

            <p class="text-gray-600 text-sm text-center mb-4">
                {{ __('messages.please_confirm_password_before_continue') }}
            </p>

            {{-- ✅ عرض الأخطاء --}}
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="mb-4">
                    <x-label for="password" :value="__('messages.password')" />
                    <x-input id="password" type="password" name="password" required autocomplete="current-password" />
                </div>

                <div>
                    <x-button class="w-full justify-center bg-yellow-500 hover:bg-yellow-600">
                        {{ __('messages.confirm_password') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
