@extends('layouts.app')

@section('content')
<div class="container">
    <h1>📋 هذه هي قائمة إعلاناتي</h1>

    @foreach ($ads as $ad)
        <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;">
            <h2>{{ $ad->title }}</h2>
            <p><strong>الوصف:</strong> {{ $ad->description }}</p>
            <p><strong>السعر:</strong> {{ $ad->price }} ل.س</p>

            @if ($ad->image)
                <div>
                    <img src="{{ asset('storage/' . $ad->image) }}" width="250" alt="صورة الإعلان">
                </div>
            @endif

            <div style="margin-top: 10px;">
                <a href="{{ route('ads.edit', $ad->id) }}">
                    <button>✏️ تعديل</button>
                </a>

                <form action="{{ route('ads.destroy', $ad->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('هل أنت متأكد أنك تريد حذف هذا الإعلان؟');">🗑️ حذف</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection
