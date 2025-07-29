<x-app-layout>
    <div class="max-w-xl mx-auto py-10 px-4">
        <h2 class="text-2xl font-bold mb-6">{{ __('messages.edit_profile') }}</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('dashboard.update_profile') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="block mb-1 font-medium">{{ __('messages.name') }}</label>
                <input type="text" name="name" id="name" class="w-full border rounded px-4 py-2" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block mb-1 font-medium">{{ __('messages.email') }}</label>
                <input type="email" name="email" id="email" class="w-full border rounded px-4 py-2" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded hover:bg-yellow-600 transition">
                {{ __('messages.save_changes') }}
            </button>
        </form>
    </div>
</x-app-layout>
