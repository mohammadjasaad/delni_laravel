<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6">

            <h1 class="text-2xl font-bold text-center text-yellow-600 mb-6">
                {{ __('messages.reset_password') }}
            </h1>

            <!-- عرض الأخطاء -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <!-- توكن إعادة التعيين -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- البريد الإلكتروني -->
                <div class="mb-4">
                    <x-label for="email" :value="__('messages.email')" />
                    <x-input id="email" type="email" name="email" class="block w-full mt-1"
                        :value="old('email', $request->email)" required autofocus />
                </div>

                <!-- كلمة المرور الجديدة -->
                <div class="mb-4">
                    <x-label for="password" :value="__('messages.new_password')" />
                    <x-input id="password" type="password" name="password" required class="block w-full mt-1" />
                </div>

                <!-- تأكيد كلمة المرور -->
                <div class="mb-6">
                    <x-label for="password_confirmation" :value="__('messages.confirm_password')" />
                    <x-input id="password_confirmation" type="password" name="password_confirmation"
                        required class="block w-full mt-1" />
                </div>

                <!-- زر إعادة التعيين -->
                <div>
                    <x-button class="w-full justify-center bg-yellow-500 hover:bg-yellow-600">
                        {{ __('messages.reset_password_button') }}
                    </x-button>
                </div>
            </form>

        </div>
    </div>
</x-guest-layout>
