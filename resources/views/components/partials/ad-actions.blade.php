{{-- resources/views/components/partials/ad-actions.blade.php --}}
<div class="flex gap-2">
    {{-- ✏️ تعديل الإعلان --}}
    <a href="{{ route('dashboard.ads.edit', $ad->id) }}"
       class="text-sm px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded shadow">
        ✏️ {{ __('mall.edit_ad') }}
    </a>

    {{-- 🗑️ حذف الإعلان --}}
    <form action="{{ route('dashboard.ads.destroy', $ad->id) }}"
          method="POST"
          onsubmit="return confirm('{{ __('mall.confirm_delete') }}');">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="text-sm px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded shadow">
            🗑️ {{ __('mall.delete') }}
        </button>
    </form>
</div>
