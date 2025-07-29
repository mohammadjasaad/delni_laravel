@extends('layouts.app')

@section('content')
<div class="container">
    <h2>📋 إعلاناتي</h2>

    <div class="mb-3 text-end">
        <a href="{{ route('dashboard.ads.create') }}" class="btn btn-success">➕ أضف إعلان جديد</a>
    </div>

    @foreach ($ads as $ad)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $ad->title }}</h5>
                <p>{{ $ad->description }}</p>
                <p><strong>السعر:</strong> {{ $ad->price }} ل.س</p>

                <a href="{{ route('ads.show', $ad->id) }}" class="btn btn-primary">عرض</a>
                <a href="{{ route('dashboard.ads.edit', $ad->id) }}" class="btn btn-warning">تعديل</a>

                <form action="{{ route('dashboard.ads.destroy', $ad->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">حذف</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection
