<x-guest-layout>
    <div class="flex justify-center items-center min-h-screen bg-gray-100">
        <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-xl border border-gray-200">

            <!-- ✅ شعار Delni -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/delnilogo.png') }}" alt="Delni Logo" class="w-24 h-24">
            </div>

            <!-- ✅ عنوان -->
            <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-6">
                {{ __('messages.register') }}
            </h2>

            <!-- ✅ عرض الأخطاء -->
            <x-validation-errors class="mb-4" />

            <!-- ✅ نموذج التسجيل -->
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- 👤 الاسم الكامل -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1 text-right">
                        {{ __('messages.name') }}
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 text-lg">👤</span>
                        <x-input id="name" 
                                 class="block w-full pr-10 text-right border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500"
                                 type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    </div>
                </div>

                <!-- 📧 البريد الإلكتروني -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1 text-right">
                        {{ __('messages.email') }}
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 text-lg">📧</span>
                        <x-input id="email" 
                                 class="block w-full pr-10 text-right border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500"
                                 type="email" name="email" :value="old('email')" required autocomplete="username" />
                    </div>
                </div>
<!-- رقم الموبايل -->
<div class="mt-4">
    <x-label for="phone" :value="__('messages.phone')" />
    <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
</div>

                <!-- 🔑 كلمة المرور -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1 text-right">
                        {{ __('messages.password') }}
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 text-lg">🔑</span>
                        <x-input id="password" 
                                 class="block w-full pr-10 text-right border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500"
                                 type="password" name="password" required autocomplete="new-password" />
                    </div>
                </div>

                <!-- ✅ تأكيد كلمة المرور -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1 text-right">
                        {{ __('messages.confirm_password') }}
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 text-lg">✅</span>
                        <x-input id="password_confirmation" 
                                 class="block w-full pr-10 text-right border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500"
                                 type="password" name="password_confirmation" required autocomplete="new-password" />
                    </div>
                </div>

                <!-- ✅ زر إنشاء الحساب -->
                <x-button class="w-full justify-center bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-3 rounded-lg shadow-md">
                    {{ __('messages.register') }}
                </x-button>
            </form>

            <!-- ✅ رابط تسجيل الدخول -->
            <div class="mt-6 text-center text-sm text-gray-600">
                {{ __('messages.already_have_account') }}
                <a href="{{ route('login') }}" class="text-yellow-600 font-bold hover:underline">
                    {{ __('messages.login') }}
                </a>
            </div>

            <!-- 🟢 تسجيل عبر واتساب -->
            <div class="mt-6">
                <a href="https://wa.me/963988779548?text=مرحباً، أريد إنشاء حساب في Delni" target="_blank"
                   class="flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white font-semibold py-3 rounded-lg shadow-md transition">
                    💬 واتساب {{ __('messages.register') }}
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
