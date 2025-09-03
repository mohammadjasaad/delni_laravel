<x-guest-layout>
    <div class="flex justify-center items-center min-h-screen bg-gray-100">
        <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-xl border border-gray-200">

            <!-- ✅ شعار Delni -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/delnilogo.png') }}" alt="Delni Logo" class="w-24 h-24">
            </div>

            <!-- ✅ عنوان -->
            <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-6">
                {{ __('messages.login') }}
            </h2>

            <!-- ✅ عرض الأخطاء -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <!-- ✅ نموذج تسجيل الدخول -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- 📧 البريد الإلكتروني -->
                <div>
                    <x-label for="email" :value="__('messages.email')" class="text-right" />
                    <div class="relative">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 text-lg">📧</span>
                        <x-input id="email"
                                 class="block w-full pr-10 text-right border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500"
                                 type="email"
                                 name="email"
                                 :value="old('email')"
                                 required autofocus />
                    </div>
                </div>

                <!-- 🔑 كلمة المرور -->
                <div>
                    <x-label for="password" :value="__('messages.password')" class="text-right" />
                    <div class="relative">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 text-lg">🔑</span>
                        <x-input id="password"
                                 class="block w-full pr-10 text-right border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500"
                                 type="password"
                                 name="password"
                                 required
                                 autocomplete="current-password" />
                    </div>
                </div>

                <!-- ✅ تذكرني + نسيت كلمة المرور -->
                <div class="flex items-center justify-between text-sm">
                    <label for="remember_me" class="flex items-center gap-2">
                        <input id="remember_me" type="checkbox"
                               class="rounded border-gray-300 text-yellow-600 focus:ring-yellow-500"
                               name="remember">
                        <span class="text-gray-600">{{ __('messages.remember_me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-yellow-600 hover:text-yellow-700 font-medium" href="{{ route('password.request') }}">
                            {{ __('messages.forgot_password') }}
                        </a>
                    @endif
                </div>

                <!-- ✅ زر تسجيل الدخول -->
                <x-button class="w-full justify-center bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-3 rounded-lg shadow-md">
                    {{ __('messages.login') }}
                </x-button>
            </form>

            <!-- ✅ رابط تسجيل جديد -->
            <div class="mt-6 text-center text-sm text-gray-600">
                {{ __('messages.no_account') }}
                <a href="{{ route('register') }}" class="text-yellow-600 font-bold hover:underline">
                    {{ __('messages.register') }}
                </a>
            </div>

            <!-- 🟢 تسجيل عبر واتساب -->
            <div class="mt-6">
                <a href="https://wa.me/963988779548?text=مرحباً، أريد التسجيل في Delni" target="_blank"
                   class="flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white font-semibold py-3 rounded-lg shadow-md transition">
                    💬 واتساب {{ __('messages.login') }}
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
