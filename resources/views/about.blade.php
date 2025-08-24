{{-- resources/views/about.blade.php --}}
<x-main-layout>
    <div class="max-w-4xl mx-auto py-10 px-4 text-gray-800">

        <h1 class="text-3xl font-bold mb-6 text-center text-yellow-500">
            {{ __('messages.about_title') }}
        </h1>

        <div class="bg-white rounded-lg shadow p-6 space-y-4 leading-relaxed">
            <p>{{ __('messages.about_description_1') }}</p>
            <p>{{ __('messages.about_description_2') }}</p>
            <p>{{ __('messages.about_description_3') }}</p>

            <ul class="list-disc list-inside text-start sm:text-center space-y-1">
                <li>{{ __('messages.about_service_taxi') }}</li>
                <li>{{ __('messages.about_service_emergency') }}</li>
                <li>{{ __('messages.about_service_transfer') }}</li>
                <li>{{ __('messages.about_service_insurance') }}</li>
                <li>{{ __('messages.about_service_auction') }}</li>
                <li>{{ __('messages.about_service_valuation') }}</li>
                <li>{{ __('messages.about_service_support') }}</li>
            </ul>

            <p>{{ __('messages.about_description_4') }}</p>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('ads.index') }}" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-2 rounded">
                {{ __('messages.browse_ads') }}
            </a>
        </div>

    </div>
</x-main-layout>
