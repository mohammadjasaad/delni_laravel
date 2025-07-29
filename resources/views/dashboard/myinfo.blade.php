<x-main-layout>

    <div class="max-w-2xl mx-auto py-10 px-4">

        {{-- العنوان --}}
        <h1 class="text-3xl font-bold mb-6">{{ __('messages.my_info') }}</h1>

<a href="{{ route('dashboard.myinfo.edit') }}"
   class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
   ✏️ تعديل البيانات
</a>

        {{-- بيانات المستخدم --}}
        <div class="bg-white shadow rounded p-6 space-y-4 mb-6">
            <p><strong>{{ __('messages.name') }}:</strong> {{ Auth::user()->name }}</p>
            <p><strong>{{ __('messages.email') }}:</strong> {{ Auth::user()->email }}</p>
            <p><strong>{{ __('messages.registered_at') }}:</strong> {{ Auth::user()->created_at->diffForHumans() }}</p>
        </div>

        {{-- زر تعديل كلمة المرور --}}
        <div class="text-right">
            <a href="{{ route('dashboard.editpassword') }}"
               class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow">
                🔒 {{ __('messages.change_password') }}
            </a>
        </div>
<a href="{{ route('dashboard.password.change') }}"
   class="mt-4 inline-block bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded">
   🔐 تغيير كلمة المرور
</a>

    </div>

</x-main-layout>
