{{-- resources/views/pages/terms.blade.php --}}
<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-10">
        <h1 class="text-2xl font-bold text-center text-yellow-600 mb-6">
            {{ __('messages.terms_conditions') }}
        </h1>

        <ul class="space-y-4 text-gray-700 dark:text-gray-300">
            <li>✔️ {{ __('messages.term_rule_1') }}</li>
            <li>✔️ {{ __('messages.term_rule_2') }}</li>
            <li>✔️ {{ __('messages.term_rule_3') }}</li>
        </ul>
    </div>
</x-app-layout>
