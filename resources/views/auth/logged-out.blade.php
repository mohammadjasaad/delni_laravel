<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6 text-center">
            <h1 class="text-3xl font-bold text-yellow-600 mb-4">
                {{ __('messages.logged_out') }}
            </h1>

            <p class="text-gray-700 mb-6">
                {{ __('messages.logged_out_message') }}
            </p>

            <a href="{{ route('login') }}" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded">
                {{ __('messages.login_again') }}
            </a>
        </div>
    </div>
</x-guest-layout>
