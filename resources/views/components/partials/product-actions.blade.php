{{-- resources/views/components/partials/product-actions.blade.php --}}
<div class="flex gap-2">
    {{-- ✏️ تعديل المنتج --}}
    <a href="{{ route('mall.products.edit', [$store->id, $product->id]) }}"
       class="text-sm px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded shadow">
        ✏️ {{ __('mall.edit_product') }}
    </a>

    {{-- 🗑️ حذف المنتج --}}
    <form action="{{ route('mall.products.destroy', [$store->id, $product->id]) }}"
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
