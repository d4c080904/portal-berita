@props(['name', 'label', 'options' => [], 'selected' => ''])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium mb-1">{{ $label }}</label>
    <select
        name="{{ $name }}"
        id="{{ $name }}"
        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-red-500 @error($name) border-red-500 @enderror"
    >
        <option value="">-- Pilih {{ $label }} --</option>
        @foreach($options as $value => $text)
            <option value="{{ $value }}" @selected(old($name, $selected) == $value)>
                {{ $text }}
            </option>
        @endforeach
    </select>
    @error($name) 
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p> 
    @enderror
</div>