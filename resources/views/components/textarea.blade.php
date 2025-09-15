@props(['id' => null, 'name', 'label' => null, 'rows' => 3, 'value' => ''])

@if($label)
    <x-label :for="$id ?? $name" :value="$label" />
@endif

<textarea
    id="{{ $id ?? $name }}"
    name="{{ $name }}"
    rows="{{ $rows }}"
    {{ $attributes->merge(['class' => 'w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500']) }}
>{{ old($name, $value) }}</textarea>
