{{-- resources/views/admin/index.blade.php --}}
<x-app-layout :isAdmin="true">
    <div class="max-w-6xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">👑 لوحة تحكم المشرف</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('admin.notifications') }}"
               class="bg-white border border-indigo-500 text-indigo-700 hover:bg-indigo-50 rounded shadow p-6 text-center font-medium">
                🔔 إشعارات المستخدمين
            </a>

            <!-- يمكنك إضافة روابط أخرى هنا مستقبلاً -->
        </div>
    </div>
</x-app-layout>
