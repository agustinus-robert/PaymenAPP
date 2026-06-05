@props([
    'type' => 'button',
    'variant' => 'dark',   // dark, primary, success, danger, etc.
    'size' => 'md',        // sm | md | lg
    'start' => null,
    'end' => null,
])

@php
    $sizes = [
        'sm' => 'btn-sm px-2',
        'md' => 'px-3',
        'lg' => 'btn-lg',
    ];

    $lineHeight = match ($size) {
        'sm' => '1.25',
        'md' => '1.35',
        'lg' => '1.5',
        default => '1.35',
    };

    $base = "btn bg-gradient-$variant {$sizes[$size]}";
@endphp

<button
    type="{{ $type }}"
    style="line-height: {{ $lineHeight }};"
    {{ $attributes->merge(['class' => $base]) }}
>
    {{-- Start --}}
    @if ($start)
        <span class="me-1 d-inline-flex align-items-center">
            {!! $start !!}
        </span>
    @endif

    {{-- Label --}}
    <span class="d-inline-flex align-items-center">
        {{ $slot }}
    </span>

    {{-- End --}}
    @if ($end)
        <span class="ms-1 d-inline-flex align-items-center">
            {!! $end !!}
        </span>
    @endif
</button>
