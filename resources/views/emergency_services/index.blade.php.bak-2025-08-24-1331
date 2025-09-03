{{-- resources/views/emergency_services/index.blade.php --}}
<x-main-layout title="مراكز الطوارئ">
    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">مراكز الطوارئ</h1>

            @php
                $hasCreate = \Illuminate\Support\Facades\Route::has('emergency_services.create');
            @endphp

            @auth
                @if($hasCreate)
                    <a href="{{ route('emergency_services.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                        + إضافة مركز
                    </a>
                @endif
            @endauth
        </div>

        @if(isset($services) && count($services))
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($services as $service)
                    <div class="bg-white shadow rounded-lg p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">
                                    {{ $service->name ?? '—' }}
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ $service->address ?? '—' }}
                                </p>
                                @if(!empty($service->phone))
                                    <p class="text-sm text-gray-700 mt-1">☎ {{ $service->phone }}</p>
                                @endif
                                @if(!empty($service->city))
                                    <p class="text-xs text-gray-500 mt-1">🏙 {{ $service->city }}</p>
                                @endif
                            </div>

                            @php
                                $hasShow    = \Illuminate\Support\Facades\Route::has('emergency_services.show');
                                $hasEdit    = \Illuminate\Support\Facades\Route::has('emergency_services.edit');
                                $hasDestroy = \Illuminate\Support\Facades\Route::has('emergency_services.destroy');
                            @endphp

                            <div class="flex items-center gap-2">
                                @if($hasShow)
                                    <a href="{{ route('emergency_services.show', $service->id) }}"
                                       class="px-3 py-1.5 text-sm bg-gray-100 rounded hover:bg-gray-200">عرض</a>
                                @endif

                                @auth
                                    @if($hasEdit)
                                        <a href="{{ route('emergency_services.edit', $service->id) }}"
                                           class="px-3 py-1.5 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600">تعديل</a>
                                    @endif

                                    @if($hasDestroy)
                                        <form action="{{ route('emergency_services.destroy', $service->id) }}"
                                              method="POST" onsubmit="return confirm('تأكيد الحذف؟');">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="px-3 py-1.5 text-sm bg-red-500 text-white rounded hover:bg-red-600">
                                                حذف
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white shadow rounded-lg p-6 text-center text-gray-600">
                لا توجد مراكز مسجلة حاليًا.
            </div>
        @endif
    </div>
</x-main-layout>
