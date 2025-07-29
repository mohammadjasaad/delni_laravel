<x-app-layout>
    @include('partials.header')

    <div class="max-w-xl mx-auto py-12 px-4">
        <h1 class="text-3xl font-bold mb-6 text-yellow-500 text-center">
            {{ __('messages.view_and_edit_profile') }}
        </h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-6 text-center">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('dashboard.update_profile') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block font-medium text-gray-700">{{ __('messages.name') }}</label>
                <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required
                    class="w-full border border-gray-300 rounded-md p-2">
            </div>

            <div>
                <label for="email" class="block font-medium text-gray-700">{{ __('messages.email') }}</label>
                <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required
                    class="w-full border border-gray-300 rounded-md p-2">
            </div>

            <div class="text-end">
                <button type="submit"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-2 rounded">
                    {{ __('messages.save_changes') }}
                </button>
            </div>
        </form>
    </div>

    @include('partials.footer')
</x-app-layout>
