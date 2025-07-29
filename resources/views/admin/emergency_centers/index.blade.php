<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-yellow-600 mb-6">🛠️ إدارة مراكز الطوارئ</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($centers as $center)
                <div class="bg-white p-4 rounded-lg shadow border border-yellow-300 relative">
                    <h2 class="text-lg font-bold text-gray-800 mb-1">🔧 {{ $center->name }}</h2>
                    <p class="text-sm text-gray-600">🏙️ {{ $center->city }} - 🛠️ {{ $center->type }}</p>
                    <p class="text-xs text-gray-500 mt-1">📍 {{ $center->lat }}, {{ $center->lng }}</p>

                    <div class="flex justify-between mt-4 text-sm font-semibold">
                        <a href="{{ route('emergency_services.show', $center->id) }}" class="text-yellow-600 hover:underline">👁️ عرض</a>
                        <a href="{{ route('emergency_services.edit', $center->id) }}" class="text-blue-600 hover:underline">✏️ تعديل</a>
                        <form method="POST" action="{{ route('emergency_services.destroy', $center->id) }}"
                              onsubmit="return confirm('هل أنت متأكد من حذف هذا المركز؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">🗑️ حذف</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ✅ روابط الصفحات --}}
        <div class="mt-8">
            {{ $centers->links() }}
        </div>
    </div>
</x-app-layout>
