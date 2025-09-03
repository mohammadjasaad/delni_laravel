{{-- resources/views/pages/faq.blade.php --}}
<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-10">
        <h1 class="text-2xl font-bold text-center text-yellow-600 mb-6">
            {{ __('messages.faq_title') }}
        </h1>

        <div class="space-y-6">
            <div>
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-1">❓ {{ __('messages.faq_q1') }}</h3>
                <p class="text-gray-600 dark:text-gray-400">{{ __('messages.faq_a1') }}</p>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-1">❓ {{ __('messages.faq_q2') }}</h3>
                <p class="text-gray-600 dark:text-gray-400">{{ __('messages.faq_a2') }}</p>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-1">❓ {{ __('messages.faq_q3') }}</h3>
                <p class="text-gray-600 dark:text-gray-400">{{ __('messages.faq_a3') }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
