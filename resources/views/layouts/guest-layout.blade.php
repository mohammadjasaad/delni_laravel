{{-- resources/views/layouts/guest-layout.blade.php --}}
{{-- ✅ Alias لواجهة الزوار - يعيد استخدام app-layout --}}
<x-app-layout :title="$title ?? config('app.name', 'Delni.co')">
    {{ $slot }}
</x-app-layout>
