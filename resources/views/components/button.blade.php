@props([
    'type' => 'button',   // button type: button, submit, reset
    'color' => 'primary', // warna: primary, danger, success, warning, light
    'size' => 'md',       // ukuran: sm, md, lg
    'disabled' => false,
])

@php
    $colors = [
        'primary' => 'bg-blue-500 text-white hover:bg-blue-600',
        'danger'  => 'bg-red-500 text-white hover:bg-red-600',
        'success' => 'bg-green-500 text-white hover:bg-green-600',
        'warning' => 'bg-yellow-400 text-black hover:bg-yellow-500',
        'light'   => 'bg-gray-200 text-black hover:bg-gray-300',
    ];

    $sizes = [
        'sm' => 'px-2 py-1 text-sm',
        'md' => 'px-4 py-2 text-base',
        'lg' => 'px-6 py-3 text-lg',
    ];
@endphp

<button
    type="{{ $type }}"
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge([
        'class' => 'rounded transition-colors duration-200 ' . ($colors[$color] ?? $colors['primary']) . ' ' . ($sizes[$size] ?? $sizes['md'])
    ]) !!}
>
    {{ $slot }}
</button>
