@extends('layouts.app')

@section('content')
<div class="container">
    <h2>✏️ تعديل بياناتي</h2>
    <form method="POST" action="{{ route('dashboard.updateInfo') }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name">الاسم:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', Auth::user()->name) }}">
        </div>

        <div class="mb-3">
            <label for="email">البريد الإلكتروني:</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', Auth::user()->email) }}">
        </div>

        <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
    </form>
</div>
@endsection
