<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold text-yellow-600 mb-6 text-center">📋 {{ __('messages.emergency_reports') }}</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded mb-6 text-center">
                {{ session('success') }}
            </div>
        @endif

        @if ($reports->isEmpty())
            <p class="text-gray-600 text-center">لا توجد بلاغات طوارئ حتى الآن.</p>
        @else
            <div class="grid gap-6">
                @foreach ($reports as $report)
                    <div class="bg-white shadow-md rounded-lg p-4 border border-gray-200">
                        <div class="flex justify-between items-center mb-2">
                            <div class="text-lg font-semibold text-gray-800">
                                🆘 {{ $report->title }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $report->created_at->format('Y-m-d H:i') }}
                            </div>
                        </div>

                        <p class="text-gray-700 mb-2">
                            {{ $report->description }}
                        </p>

                        <div class="flex justify-between items-center text-sm text-gray-600">
                            <div>📍 {{ $report->city }}</div>
                            <div>👤 {{ $report->user->name ?? 'غير معروف' }}</div>
                        </div>

                        <form method="POST" action="{{ route('emergency_reports.destroy', $report->id) }}" class="mt-4 text-right">
                            @csrf
                            @method('DELETE')
                            <x-danger-button onclick="return confirm('هل أنت متأكد من حذف البلاغ؟')">
                                🗑️ حذف البلاغ
                            </x-danger-button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
