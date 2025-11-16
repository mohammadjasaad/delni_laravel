{{-- resources/views/dashboard/myinfo.blade.php --}}
<x-app-layout>
<div class="max-w-5xl mx-auto px-4 py-8">

    {{-- 🟡 العنوان --}}
    <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-8 flex items-center gap-2">
        <i class="fas fa-user-circle text-yellow-500"></i> {{ __('messages.my_info') }}
    </h1>

    {{-- 📝 بطاقة بيانات المستخدم --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 space-y-6 transition">

        {{-- 👤 الاسم --}}
        <div class="flex items-center justify-between border-b dark:border-gray-700 pb-4">
            <span class="flex items-center gap-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                <i class="fas fa-user text-blue-500"></i> {{ __('messages.name') }}
            </span>
            <span class="text-gray-900 dark:text-white font-bold">{{ auth()->user()->name }}</span>
        </div>

        {{-- 📧 البريد الإلكتروني --}}
        <div class="flex items-center justify-between border-b dark:border-gray-700 pb-4">
            <span class="flex items-center gap-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                <i class="fas fa-envelope text-green-500"></i> {{ __('messages.email') }}
            </span>
            <span class="text-gray-900 dark:text-white font-bold">{{ auth()->user()->email }}</span>
        </div>

{{-- 📱 رقم الموبايل --}}
<div class="flex items-center justify-between border-b dark:border-gray-700 pb-4">
    <span class="flex items-center gap-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
        <i class="fas fa-phone text-yellow-500"></i> {{ __('messages.phone') }}
    </span>

    <span class="text-gray-800 dark:text-white font-bold tracking-wide">
        {{ $user->phone ? '+'. ltrim($user->phone, '+') : '-' }}
    </span>
</div>

        {{-- 📅 تاريخ التسجيل --}}
        <div class="flex items-center justify-between border-b dark:border-gray-700 pb-4">
            <span class="flex items-center gap-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                <i class="fas fa-calendar-alt text-purple-500"></i> {{ __('messages.registered_at') }}
            </span>
            <span class="text-gray-900 dark:text-white font-bold">{{ auth()->user()->created_at->format('Y-m-d') }}</span>
        </div>

        {{-- 🏷️ الدور --}}
        <div class="flex items-center justify-between">
            <span class="flex items-center gap-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                <i class="fas fa-user-shield text-red-500"></i> {{ __('messages.role') }}
            </span>
            <span class="px-3 py-1 rounded-full text-sm font-bold 
                         {{ auth()->user()->role == 'admin' 
                            ? 'bg-red-100 text-red-600 dark:bg-red-700 dark:text-red-200' 
                            : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300' }}">
                {{ auth()->user()->role == 'admin' ? __('messages.admin') : __('messages.user') }}
            </span>
        </div>
    </div>

    {{-- 🔘 أزرار --}}
    <div class="flex flex-wrap gap-3 mt-8">
        <a href="{{ route('dashboard.myinfo.edit') }}" 
           class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg shadow transition transform hover:scale-105">
            <i class="fas fa-edit"></i> {{ __('messages.edit_info') }}
        </a>
        <a href="{{ route('dashboard.password.change') }}" 
           class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg shadow transition transform hover:scale-105">
            <i class="fas fa-key"></i> {{ __('messages.change_password') }}
        </a>
    </div>
</div>

{{-- ✅ FontAwesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</x-app-layout>
