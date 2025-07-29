<x-guest-layout>
    <div class="max-w-md mx-auto mt-16 p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold text-center text-yellow-600 mb-6">🧑‍✈️ تسجيل دخول السائق</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('driver.login.submit') }}">
            @csrf

            <div class="mb-4">
                <x-label for="email" :value="'البريد الإلكتروني'" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" required autofocus />
            </div>

            <div class="mb-6">
                <x-label for="password" :value="'كلمة المرور'" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            </div>

            <div>
                <x-button class="w-full justify-center">
                    🚕 دخول
                </x-button>
            </div>
        </form>
    </div>
</x-guest-layout>
