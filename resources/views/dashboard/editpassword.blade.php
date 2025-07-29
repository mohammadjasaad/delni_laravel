<x-app-layout>
    <div class="max-w-md mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.change_password') }}</h1>

        @if (session('status'))
            <div class="mb-4 text-green-600 font-semibold">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('dashboard.password.update') }}" class="space-y-6">
            @csrf

            {{-- كلمة المرور الحالية --}}
            <div>
                <x-label for="current_password" :value="__('messages.current_password')" />
                <x-input id="current_password" type="password" name="current_password" required class="w-full mt-1" />
            </div>

            {{-- كلمة المرور الجديدة --}}
            <div>
                <x-label for="password" :value="__('messages.new_password')" />
                <x-input id="password" type="password" name="password" required class="w-full mt-1" />
            </div>

            {{-- تأكيد كلمة المرور --}}
            <div>
                <x-label for="password_confirmation" :value="__('messages.confirm_password')" />
                <x-input id="password_confirmation" type="password" name="password_confirmation" required class="w-full mt-1" />
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                    {{ __('messages.save') }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
