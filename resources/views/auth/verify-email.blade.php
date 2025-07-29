<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
        <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6">

            <h1 class="text-2xl font-bold text-center text-yellow-600 mb-6">
                {{ __('messages.verify_email') }}
            </h1>

            @if (session('status') === 'verification-link-sent')
                <div class="mb-4 text-green-600 text-sm text-center font-semibold">
                    {{ __('messages.verification_link_sent') }}
                </div>
            @endif

            <p class="text-gray-600 text-sm text-center mb-6 leading-relaxed">
                {{ __('messages.verify_email_instruction') }}
            </p>

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <div class="flex items-center justify-center">
                    <x-button class="bg-yellow-500 hover:bg-yellow-600">
                        {{ __('messages.resend_verification_email') }}
                    </x-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="mt-4 text-center">
                @csrf
                <button type="submit" class="text-sm text-gray-500 underline hover:text-gray-700">
                    {{ __('messages.logout') }}
                </button>
            </form>

        </div>
    </div>
</x-guest-layout>
