@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>قائمة إعلاناتي</h1>

        @foreach ($ads as $ad)
            <div>
                <h2>{{ $ad->title }}</h2>
                <p>{{ $ad->description }}</p>
                <p>السعر: {{ $ad->price }}</p>
                <p>الموقع: {{ $ad->location }}</p>
                @if ($ad->image)
                    <img src="{{ asset($ad->image) }}" width="150">
                @endif
            </div>
            <hr>
        @endforeach
    </div>
@endsection
