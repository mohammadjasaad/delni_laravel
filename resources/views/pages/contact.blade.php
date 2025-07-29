@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">{{ __('messages.contact_title') }}</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('contact.send') }}">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-semibold mb-2">{{ __('messages.contact_name') }}</label>
            <input type="text" name="name" id="name" class="form-control w-full" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-semibold mb-2">{{ __('messages.contact_email') }}</label>
            <input type="email" name="email" id="email" class="form-control w-full" required>
        </div>

        <div class="mb-4">
            <label for="message" class="block text-gray-700 font-semibold mb-2">{{ __('messages.contact_message') }}</label>
            <textarea name="message" id="message" rows="5" class="form-control w-full" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            {{ __('messages.contact_submit') }}
        </button>
    </form>
</div>
@endsection
