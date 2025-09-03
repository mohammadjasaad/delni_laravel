<x-guest-layout>
    <div class="flex justify-center items-center min-h-screen bg-gray-100 px-4">
        <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-xl border border-gray-200">

            <!-- 🖼️ شعار -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/delnilogo.png') }}" alt="Delni Logo" class="w-24 h-24">
            </div>

            <!-- 🔒 العنوان -->
            <h1 class="text-3xl font-extrabold text-center text-gray-800 mb-4">
                🔒 {{ __('messages.confirm_password') }}
            </h1>

            <!-- ⚠️ الرسالة التوضيحية -->
            <p class="text-gray-600 text-sm text-center mb-6 leading-relaxed">
                ⚠️ {{ __('messages.confirm_password_message') }}
            </p>

            <!-- ⚠️ عرض الأخطاء -->
            <x-validation-errors class="mb-4" />

            <!-- ✅ النموذج -->
            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
                @csrf

                <!-- كلمة المرور -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1 text-right">
                        {{ __('messages.password') }}
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 text-lg">🔑</span>
                        <x-input id="password" type="password" name="password"
                                 class="block w-full pr-10 text-right border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500"
                                 required autocomplete="current-password" />
                    </div>
                </div>

                <!-- زر التأكيد -->
                <div>
                    <x-button class="w-full justify-center bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-3 rounded-lg shadow-md">
                        {{ __('messages.confirm_button') }}
                    </x-button>
                </div>
            </form>

            <!-- 🔗 نسيت كلمة المرور -->
            @if (Route::has('password.request'))
                <div class="mt-6 text-center text-sm">
                    <a class="text-yellow-600 font-bold hover:underline" href="{{ route('password.request') }}">
                        {{ __('messages.forgot_password') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-guest-layout>
