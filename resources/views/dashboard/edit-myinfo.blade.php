<x-app-layout>
    <div class="max-w-2xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">👤 {{ __('messages.edit_my_info') }}</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('dashboard.myinfo.update') }}" class="space-y-4">
            @csrf

            <!-- الاسم -->
            <div>
                <x-label for="name" :value="__('messages.name')" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                         value="{{ old('name', $user->name) }}" required autofocus />
            </div>

            <!-- البريد -->
            <div>
                <x-label for="email" :value="__('messages.email')" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                         value="{{ old('email', $user->email) }}" required />
            </div>

            <!-- زر حفظ -->
            <div class="pt-4">
                <x-primary-button>
                    💾 {{ __('messages.save_changes') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
