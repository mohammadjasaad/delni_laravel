<x-guest-layout>
    <div class="flex justify-center items-center min-h-screen bg-gray-100">
        <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
            <!-- ✅ شعار Delni -->
            <div class="flex justify-center mb-6">
                <img src="/images/logo-delni.png" alt="Delni Logo" class="w-20 h-20">
            </div>

            <!-- ✅ عنوان -->
            <h2 class="text-2xl font-bold text-center text-yellow-600 mb-6">تسجيل الدخول</h2>

            <!-- ✅ نموذج تسجيل الدخول -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- ✅ البريد الإلكتروني -->
                <div class="mb-4">
                    <label for="email" class="block text-right text-sm font-medium text-gray-700 mb-1">
                        البريد الإلكتروني
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 text-xl">📧</span>
                        <x-input id="email" class="block w-full pr-10 text-right" type="email" name="email" :value="old('email')" required autofocus />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-right" />
                </div>

                <!-- ✅ كلمة المرور -->
                <div class="mb-4">
                    <label for="password" class="block text-right text-sm font-medium text-gray-700 mb-1">
                        كلمة المرور
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 text-xl">🔒</span>
                        <x-input id="password" class="block w-full pr-10 text-right" type="password" name="password" required autocomplete="current-password" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-right" />
                </div>

                <!-- ✅ تذكرني -->
                <div class="flex items-center justify-between mb-6">
                    <label for="remember_me" class="flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-yellow-600 shadow-sm focus:ring-yellow-500" name="remember">
                        <span class="ml-2 text-sm text-gray-600">تذكرني</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-yellow-600 hover:underline" href="{{ route('password.request') }}">
                            نسيت كلمة المرور؟
                        </a>
                    @endif
                </div>

                <!-- ✅ زر تسجيل الدخول -->
                <x-button class="w-full justify-center bg-yellow-500 hover:bg-yellow-600">
                    تسجيل الدخول
                </x-button>
            </form>

            <!-- ✅ رابط تسجيل جديد -->
            <div class="mt-6 text-center text-sm text-gray-600">
                لا تملك حساباً؟ 
                <a href="{{ route('register') }}" class="text-yellow-600 hover:underline">أنشئ حسابك</a>
            </div>
        </div>
    </div>
</x-guest-layout>
