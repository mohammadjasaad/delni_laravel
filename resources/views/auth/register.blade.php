<x-guest-layout>
    <div class="flex justify-center items-center min-h-screen bg-gray-100">
        <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
            <!-- ✅ شعار Delni -->
            <div class="flex justify-center mb-6">
                <img src="/images/logo-delni.png" alt="Delni Logo" class="w-20 h-20">
            </div>

            <!-- ✅ عنوان -->
            <h2 class="text-2xl font-bold text-center text-yellow-600 mb-6">إنشاء حساب جديد</h2>

            <!-- ✅ نموذج التسجيل -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- ✅ الاسم الكامل -->
                <div class="mb-4">
                    <label for="name" class="block text-right text-sm font-medium text-gray-700 mb-1">
                        الاسم الكامل
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 text-xl">👤</span>
                        <x-input id="name" class="block w-full pr-10 text-right" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-right" />
                </div>

                <!-- ✅ البريد الإلكتروني -->
                <div class="mb-4">
                    <label for="email" class="block text-right text-sm font-medium text-gray-700 mb-1">
                        البريد الإلكتروني
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 text-xl">📧</span>
                        <x-input id="email" class="block w-full pr-10 text-right" type="email" name="email" :value="old('email')" required autocomplete="username" />
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
                        <x-input id="password" class="block w-full pr-10 text-right" type="password" name="password" required autocomplete="new-password" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-right" />
                </div>

                <!-- ✅ تأكيد كلمة المرور -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-right text-sm font-medium text-gray-700 mb-1">
                        تأكيد كلمة المرور
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 text-xl">✅</span>
                        <x-input id="password_confirmation" class="block w-full pr-10 text-right" type="password" name="password_confirmation" required autocomplete="new-password" />
                    </div>
                </div>

                <!-- ✅ زر إنشاء الحساب -->
                <x-button class="w-full justify-center bg-yellow-500 hover:bg-yellow-600">
                    إنشاء حساب
                </x-button>
            </form>

            <!-- ✅ رابط تسجيل الدخول -->
            <div class="mt-6 text-center text-sm text-gray-600">
                لديك حساب بالفعل؟ 
                <a href="{{ route('login') }}" class="text-yellow-600 hover:underline">تسجيل الدخول</a>
            </div>
        </div>
    </div>
</x-guest-layout>
