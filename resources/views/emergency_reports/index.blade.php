<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-4">

        {{-- ✅ عنوان الصفحة --}}
        <h1 class="text-3xl font-bold text-center text-red-600 mb-8">📋 {{ __('messages.emergency_reports') }}</h1>

        {{-- ✅ إشعار النجاح --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-6 text-center">
                {{ session('success') }}
            </div>
        @endif

        {{-- ✅ جدول البلاغات --}}
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-800 border border-gray-200">
                <thead class="bg-yellow-100">
                    <tr>
                        <th class="px-4 py-2 text-start font-bold">🔧 {{ __('messages.center_name') }}</th>
                        <th class="px-4 py-2 text-start font-bold">🏙️ {{ __('messages.city') }}</th>
                        <th class="px-4 py-2 text-start font-bold">📝 {{ __('messages.report_reason') }}</th>
                        <th class="px-4 py-2 text-start font-bold">📅 {{ __('messages.date') }}</th>
                        <th class="px-4 py-2 text-center font-bold">❌ {{ __('messages.delete') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($reports as $report)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $report->service->name }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $report->service->city }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $report->reason }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $report->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-4 py-3 text-center">
                                <form method="POST" action="{{ route('emergency_reports.destroy', $report->id) }}"
                                      onsubmit="return confirm('{{ __('messages.confirm_delete') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800 font-semibold text-sm" title="{{ __('messages.delete') }}">
                                        🗑️
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                {{ __('messages.no_reports_found') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
