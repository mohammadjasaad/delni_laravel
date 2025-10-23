<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">🖼️ إدارة بانرات المول</h1>

        <a href="{{ route('mall-banners.create') }}" 
           class="mb-4 inline-block px-4 py-2 bg-yellow-400 text-black rounded hover:bg-yellow-500">
            ➕ إضافة بانر جديد
        </a>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($banners as $banner)
                <div class="border rounded-lg shadow-sm p-3 bg-white dark:bg-gray-800">
                    <img src="{{ asset('storage/'.$banner->image_desktop) }}" 
                         class="w-full h-40 object-cover rounded mb-3">
                    <h2 class="font-semibold text-gray-800 dark:text-gray-200">{{ $banner->title }}</h2>
                    <a href="{{ $banner->link }}" target="_blank" 
                       class="text-blue-500 text-sm break-all">{{ $banner->link }}</a>

                    <div class="flex gap-2 mt-3">
                        <a href="{{ route('mall-banners.edit', $banner->id) }}" 
                           class="px-3 py-1 bg-yellow-400 text-black rounded hover:bg-yellow-500">✏️ تعديل</a>
                        <form action="{{ route('mall-banners.destroy', $banner->id) }}" method="POST" 
                              onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">🗑️ حذف</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">{{ $banners->links() }}</div>
    </div>
</x-app-layout>
