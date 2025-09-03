{{-- resources/views/faq.blade.php --}}
<x-app-layout title="Delni.co - {{ __('messages.faq_title') }}">
    <div class="max-w-4xl mx-auto py-12 px-4">
        <h1 class="text-3xl font-bold text-yellow-500 text-center mb-6">
            {{ __('messages.faq_title') }}
        </h1>

        <div class="space-y-6 text-gray-700">
            <div>
                <h2 class="font-semibold">{{ __('messages.faq_q1') }}</h2>
                <p>{{ __('messages.faq_a1') }}</p>
            </div>

            <div>
                <h2 class="font-semibold">{{ __('messages.faq_q2') }}</h2>
                <p>{{ __('messages.faq_a2') }}</p>
            </div>

            <div>
                <h2 class="font-semibold">{{ __('messages.faq_q3') }}</h2>
                <p>{{ __('messages.faq_a3') }}</p>
            </div>

            <div>
                <h2 class="font-semibold">{{ __('messages.faq_q4') }}</h2>
                <p>{{ __('messages.faq_a4') }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
