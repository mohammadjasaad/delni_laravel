@props(['disabled' => false, 'type' => 'text'])

<input 
    {{ $disabled ? 'disabled' : '' }} 
    type="{{ $type }}" 
    {{ $attributes->merge(['class' => 'border-gray-300 focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50 rounded-md shadow-sm']) }} 
/>
