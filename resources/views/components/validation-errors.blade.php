{{-- resources/views/components/validation-errors.blade.php --}}
@if ($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex items-center text-red-700 mb-2">
            <span class="text-xl mr-2">⚠️</span>
            <h3 class="font-semibold">{{ __('messages.validation_failed') }}</h3>
        </div>
        <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
