<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
        <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6">

            <h1 class="text-2xl font-bold text-center text-yellow-600 mb-6">
                {{ __('messages.forgot_password') }}
            </h1>

            {{-- ✅ عرض رسالة نجاح عند إرسال الرابط --}}
            @if (session('status'))
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 text-sm text-center">
                    {{ session('status') }}
                </div>
            @endif

            {{-- 📧 نموذج إرسال رابط إعادة التعيين --}}
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-4">
                    <x-label for="email" :value="__('messages.email')" />
                    <x-input id="email" type="email" name="email" :value="old('email')" required autofocus />
                </div>

                <div>
                    <x-button class="w-full justify-center bg-yellow-500 hover:bg-yellow-600">
                        {{ __('messages.send_password_reset_link') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
