{{-- resources/views/dashboard/support/create.blade.php --}}
<x-app-layout>
    <div class="max-w-3xl mx-auto py-10 px-4">
        
        {{-- 🟡 العنوان --}}
        <h1 class="text-2xl font-bold text-yellow-600 mb-6 text-center">
            ➕ {{ __('messages.add_new_ticket') ?? 'Add New Ticket' }}
        </h1>

        {{-- ✅ عرض الأخطاء --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ✅ نموذج إضافة تذكرة --}}
        <form method="POST" action="{{ route('support.store') }}" class="space-y-6">
            @csrf

            {{-- 📌 الموضوع --}}
            <div>
                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('messages.subject') ?? 'Subject' }}
                </label>
                <input type="text" id="subject" name="subject" value="{{ old('subject') }}"
                       class="w-full border rounded-lg px-4 py-2 focus:ring-yellow-500 focus:border-yellow-500">
            </div>

            {{-- 💬 الرسالة --}}
            <div>
                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('messages.message') ?? 'Message' }}
                </label>
                <textarea id="message" name="message" rows="6"
                          class="w-full border rounded-lg px-4 py-2 focus:ring-yellow-500 focus:border-yellow-500">{{ old('message') }}</textarea>
            </div>

            {{-- زر الإرسال --}}
            <div class="text-right">
                <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg shadow font-semibold">
                    {{ __('messages.send_message') ?? 'Send' }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
