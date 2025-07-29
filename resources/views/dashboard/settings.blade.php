<x-app-layout>
    <div class="max-w-2xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">⚙️ {{ __('messages.account_settings') }}</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('dashboard.settings.update') }}" class="space-y-6">
            @csrf

            <!-- الاسم -->
            <div>
                <x-label for="name" :value="__('messages.name')" />
                <x-input id="name" type="text" name="name" class="block mt-1 w-full"
                         value="{{ old('name', $user->name) }}" required />
            </div>

            <!-- البريد -->
            <div>
                <x-label for="email" :value="__('messages.email')" />
                <x-input id="email" type="email" name="email" class="block mt-1 w-full"
                         value="{{ old('email', $user->email) }}" required />
            </div>

            <!-- كلمة المرور الحالية -->
            <div>
                <x-label for="current_password" :value="__('messages.current_password')" />
                <x-input id="current_password" type="password" name="current_password" class="block mt-1 w-full" />
                <small class="text-gray-500">{{ __('messages.leave_blank_if_no_change') }}</small>
            </div>

            <!-- كلمة المرور الجديدة -->
            <div>
                <x-label for="new_password" :value="__('messages.new_password')" />
                <x-input id="new_password" type="password" name="new_password" class="block mt-1 w-full" />
            </div>

            <!-- تأكيد كلمة المرور -->
            <div>
                <x-label for="new_password_confirmation" :value="__('messages.confirm_password')" />
                <x-input id="new_password_confirmation" type="password" name="new_password_confirmation" class="block mt-1 w-full" />
            </div>

<a href="{{ route('dashboard.settings') }}"
   class="inline-block bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded mt-4">
   ⚙️ إعدادات الحساب
</a>

            <x-primary-button>
                💾 {{ __('messages.save_changes') }}
            </x-primary-button>
        </form>
    </div>
</x-app-layout>
