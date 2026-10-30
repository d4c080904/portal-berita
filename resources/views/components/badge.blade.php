@props(['type' => 'gray'])

@php
    $classes = match($type) {
        'success' => 'bg-green-100 text-green-700',
        'warning' => 'bg-yellow-100 text-yellow-800',
        'danger'  => 'bg-red-100 text-red-700',
        default   => 'bg-gray-100 text-gray-600',
    };
@endphp

<span {{ $attributes->merge(['class' => "px-2.5 py-1 rounded-full text-xs font-semibold $classes"]) }}>
    {{ $slot }}
</span>