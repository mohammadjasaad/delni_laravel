@extends('layouts.app')

@section('content')
<div class="container">
    <h2>➕ إضافة إعلان جديد</h2>

    <form method="POST" action="{{ route('dashboard.ads.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>العنوان</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>الوصف</label>
            <textarea name="description" class="form-control" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label>السعر</label>
            <input type="number" name="price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>المدينة</label>
            <input type="text" name="city" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>التصنيف</label>
            <input type="text" name="category" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>صور الإعلان</label>
            <input type="file" name="images[]" multiple class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">نشر الإعلان</button>
    </form>
</div>
@endsection
