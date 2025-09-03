<x-guest-layout>
    <div class="flex justify-center items-center min-h-screen bg-gray-100 px-4">
        <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-xl border border-gray-200">

            <!-- 🖼️ شعار -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/delnilogo.png') }}" alt="Delni Logo" class="w-24 h-24">
            </div>

            <!-- 🔑 العنوان -->
            <h1 class="text-3xl font-extrabold text-center text-gray-800 mb-6">
                🔑 {{ __('messages.reset_password') }}
            </h1>

            <!-- ⚠️ عرض الأخطاء -->
            <x-validation-errors class="mb-4" />

            <!-- ✅ رسالة نجاح -->
            @if (session('status'))
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded-lg mb-4 text-sm text-center shadow">
                    ✅ {{ session('status') }}
                </div>
            @endif

            <!-- ✅ النموذج -->
            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                @csrf

                <!-- توكن إعادة التعيين -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- 📧 البريد الإلكتروني -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1 text-right">
                        {{ __('messages.email') }}
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 text-lg">📧</span>
                        <x-input id="email" type="email" name="email"
                                 class="block w-full pr-10 text-right border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500"
                                 :value="old('email', $request->email)" required autofocus />
                    </div>
                </div>

                <!-- 🔒 كلمة المرور الجديدة -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1 text-right">
                        {{ __('messages.new_password') }}
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 text-lg">🔒</span>
                        <x-input id="password" type="password" name="password"
                                 class="block w-full pr-10 text-right border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500"
                                 required autocomplete="new-password" />
                    </div>
                </div>

                <!-- ✅ تأكيد كلمة المرور -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1 text-right">
                        {{ __('messages.confirm_new_password') }}
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 text-lg">✅</span>
                        <x-input id="password_confirmation" type="password" name="password_confirmation"
                                 class="block w-full pr-10 text-right border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500"
                                 required autocomplete="new-password" />
                    </div>
                </div>

                <!-- 🟡 زر إعادة التعيين -->
                <div>
                    <x-button class="w-full justify-center bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-3 rounded-lg shadow-md">
                        {{ __('messages.reset_password_button') }}
                    </x-button>
                </div>
            </form>

            <!-- 🔙 العودة لتسجيل الدخول -->
            <div class="mt-6 text-center text-sm text-gray-600">
                🔙 <a href="{{ route('login') }}" class="text-yellow-600 font-bold hover:underline">
                    {{ __('messages.back_to_login') ?? 'العودة لتسجيل الدخول' }}
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
