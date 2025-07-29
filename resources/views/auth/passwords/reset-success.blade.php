<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
        <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6 text-center">

            {{-- 🎉 عنوان النجاح --}}
            <h1 class="text-2xl font-bold text-green-600 mb-4">
                {{ __('messages.password_reset_success') }}
            </h1>

            {{-- ✅ رسالة النجاح --}}
            <p class="text-gray-700 mb-6">
                {{ __('messages.password_reset_success_message') }}
            </p>

            {{-- 🔐 زر تسجيل الدخول --}}
            <a href="{{ route('login') }}"
               class="inline-block bg-yellow-500 text-white font-semibold py-2 px-4 rounded hover:bg-yellow-600 transition">
                {{ __('messages.login_now') }}
            </a>

        </div>
    </div>
</x-guest-layout>
