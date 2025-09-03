<x-guest-layout>
    <div class="flex justify-center items-center min-h-screen bg-gray-100 px-4">
        <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-xl border border-gray-200">

            <!-- 🖼️ شعار -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/delnilogo.png') }}" alt="Delni Logo" class="w-24 h-24">
            </div>

            <!-- ✉️ العنوان -->
            <h1 class="text-3xl font-extrabold text-center text-gray-800 mb-4">
                ✉️ {{ __('messages.verify_email_title') }}
            </h1>

            <!-- 📝 الوصف -->
            <p class="text-gray-600 text-sm text-center mb-6 leading-relaxed">
                {{ __('messages.verify_email_message') }}
            </p>

            <!-- ✅ إشعار نجاح عند إعادة إرسال الرابط -->
            @if (session('status') == 'verification-link-sent')
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded-lg mb-4 text-sm text-center shadow">
                    ✅ {{ __('messages.verification_link_sent') }}
                </div>
            @endif

            <!-- 🔁 إعادة إرسال رابط التفعيل -->
            <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
                @csrf
                <x-button class="w-full justify-center bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-3 rounded-lg shadow-md">
                    {{ __('messages.resend_verification_email') }}
                </x-button>
            </form>

            <!-- 🔙 تسجيل الخروج -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-button class="w-full justify-center bg-red-500 hover:bg-red-600 text-white font-bold py-3 rounded-lg shadow-md">
                    {{ __('messages.logout') }}
                </x-button>
            </form>

        </div>
    </div>
</x-guest-layout>
