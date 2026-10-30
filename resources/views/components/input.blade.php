@props(['name', 'label', 'type' => 'text', 'value' => '', 'placeholder' => ''])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium mb-1">{{ $label }}</label>
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-red-500 @error($name) border-red-500 @enderror"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
    >
    @error($name) 
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p> 
    @enderror
</div>