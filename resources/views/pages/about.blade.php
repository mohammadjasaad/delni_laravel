@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ __('messages.about_title') }}</h1>

    <p class="text-gray-700 leading-relaxed mb-4">
        {{ __('messages.about_text_1') }}
    </p>

    <p class="text-gray-700 leading-relaxed mb-4">
        {{ __('messages.about_text_2') }}
    </p>

    <p class="text-gray-700 leading-relaxed">
        {{ __('messages.about_text_3') }}
    </p>
</div>
@endsection
