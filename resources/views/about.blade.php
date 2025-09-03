<x-main-layout>
    <div class="max-w-4xl mx-auto py-10 px-4 text-gray-800">

        <h1 class="text-3xl font-bold mb-6 text-center text-yellow-500">
            {{ __('messages.about_us') }}
        </h1>

<div class="bg-white rounded-lg shadow p-6 space-y-4 leading-relaxed text-lg">
    {!! nl2br(e(__('messages.about_full'))) !!}
</div>

        <div class="mt-8 text-center">
            <a href="{{ route('ads.index') }}" 
               class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-2 rounded">
                {{ __('messages.browse_ads') }}
            </a>
        </div>

    </div>
</x-main-layout>
