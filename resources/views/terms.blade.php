<x-guest-layout>
    @include('partials.header')

    <div class="max-w-4xl mx-auto py-12 px-4">
        <h1 class="text-3xl font-bold text-yellow-500 text-center mb-6">
            {{ __('messages.terms_conditions') }}
        </h1>

        <p class="text-gray-700 text-lg leading-relaxed mb-8 text-center">
            {{ __('messages.terms_intro') }}
        </p>

        <div class="space-y-6 text-gray-700 text-base">
            <p>{{ __('messages.terms_text_1') }}</p>
            <p>{{ __('messages.terms_text_2') }}</p>
            <p>{{ __('messages.terms_text_3') }}</p>
        </div>
    </div>

    @include('partials.footer')
</x-guest-layout>
