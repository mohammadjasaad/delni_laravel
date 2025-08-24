<x-app-layout>
    <div class="max-w-2xl mx-auto py-10 px-4" dir="rtl">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">{{ __('messages.my_info') }}</h1>

        <div class="bg-white shadow rounded p-6 space-y-4 mb-6">
            <p><strong>{{ __('messages.name') }}:</strong> {{ Auth::user()->name }}</p>
            <p><strong>{{ __('messages.email') }}:</strong> {{ Auth::user()->email }}</p>
            <p><strong>{{ __('messages.registered_at') }}:</strong> {{ Auth::user()->created_at->diffForHumans() }}</p>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('dashboard.myinfo.edit') }}"
               class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">✏️ تعديل البيانات</a>

            {{-- مساران متاحان لتغيير كلمة المرور للمحافظة على التوافق --}}
            <a href="{{ route('dashboard.editpassword') }}"
               class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">🔒 {{ __('messages.change_password') }}</a>

            <a href="{{ route('dashboard.password.change') }}"
               class="inline-block bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded">🔐 تغيير كلمة المرور</a>
        </div>
    </div>
</x-app-layout>
