@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">📢 جميع الإعلانات</h2>
    <div class="row">

        @foreach($ads as $ad)
            <div class="col-md-4 mb-4">
                <div class="card h-100">

                    {{-- عرض جميع الصور --}}
                    @if(is_array($ad->images) && count($ad->images) > 0)
                    <div id="ad-images-{{ $ad->id }}" class="d-flex flex-wrap justify-content-center gap-2 p-2">
    @foreach($ad->images as $img)
        <img src="{{ asset('storage/' . $img) }}"
             alt="صورة الإعلان"
             class="img-thumbnail"
             style="width: 100px; height: 100px; object-fit: cover;">
    @endforeach
</div>

                    @else
                        <div class="text-center text-muted pt-4">🖼️ لا صورة</div>
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $ad->title }}</h5>
                        <p class="card-text">{{ Str::limit($ad->description, 100) }}</p>
                        <p><strong>💰 السعر:</strong> {{ number_format($ad->price, 2) }} ل.س</p>
                        <a href="{{ route('ads.show', $ad->id) }}" class="btn btn-primary">عرض التفاصيل</a>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>
@endsection
