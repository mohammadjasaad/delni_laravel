<x-app-layout>
    <div class="max-w-xl mx-auto py-10 px-4">
        <h2 class="text-2xl font-bold text-center text-yellow-600 mb-6">
            🔐 {{ __('messages.change_password') }}
        </h2>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5 space-y-1 text-sm text-start">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('dashboard.updatepassword') }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <x-label for="current_password" :value="__('messages.current_password')" />
                <x-input id="current_password" type="password" name="current_password" required autocomplete="current-password" class="mt-1 block w-full" />
            </div>

            <div class="mb-4">
                <x-label for="password" :value="__('messages.new_password')" />
                <x-input id="password" type="password" name="password" required autocomplete="new-password" class="mt-1 block w-full" />
            </div>

            <div class="mb-6">
                <x-label for="password_confirmation" :value="__('messages.confirm_new_password')" />
                <x-input id="password_confirmation" type="password" name="password_confirmation" required class="mt-1 block w-full" />
            </div>

            <x-primary-button class="w-full justify-center bg-yellow-500 hover:bg-yellow-600">
                💾 {{ __('messages.save_changes') }}
            </x-primary-button>
        </form>
    </div>
</x-app-layout>
