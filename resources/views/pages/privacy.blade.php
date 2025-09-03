{{-- resources/views/pages/privacy.blade.php --}}
<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-10">
        <h1 class="text-2xl font-bold text-center text-yellow-600 mb-6">
            {{ __('messages.privacy_policy') }}
        </h1>

        <div class="bg-white dark:bg-gray-900 p-6 rounded shadow text-gray-700 dark:text-gray-300 space-y-3">
            <p>🔒 {{ __('messages.privacy_text1') }}</p>
            <p>✅ {{ __('messages.privacy_text2') }}</p>
            <p>⚠️ {{ __('messages.privacy_text3') }}</p>
        </div>
    </div>
</x-app-layout>
