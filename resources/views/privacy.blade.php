<x-guest-layout>
    @include('partials.header')

    <div class="max-w-3xl mx-auto py-12 px-6">
        <h1 class="text-3xl font-bold text-yellow-500 text-center mb-6">
            {{ __('messages.privacy_policy') }}
        </h1>

        <p class="text-gray-700 text-base leading-relaxed mb-4 text-center">
            {{ __('messages.privacy_intro') }}
        </p>

        <div class="space-y-4 text-gray-700 text-base">
            <p>• {{ __('messages.privacy_data_collection') }}</p>
            <p>• {{ __('messages.privacy_data_usage') }}</p>
            <p>• {{ __('messages.privacy_data_sharing') }}</p>
            <p>• {{ __('messages.privacy_security') }}</p>
            <p>• {{ __('messages.privacy_rights') }}</p>
            <p>• {{ __('messages.privacy_contact') }}</p>
        </div>
    </div>

    @include('partials.footer')
</x-guest-layout>

