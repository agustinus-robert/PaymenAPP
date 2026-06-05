@props([
    'for'   => null,
    'value' => null,
    'col'   => null,
    'size'  => 'md',
    'muted' => false,
])

@php
    $classes = 'col-form-label';

    if ($col) {
        foreach (explode(' ', $col) as $part) {
            if (str_contains($part, '-')) {
                [$sizeCol, $bp] = explode('-', $part);
                $classes = "col-$bp-$sizeCol $classes";
            } else {
                $classes = "col-$part $classes";
            }
        }
    }

    $textClass = match ($size) {
        'sm' => 'small',
        'lg' => 'fs-5 fw-semibold',
        default => '',
    };

    $mutedClass = $muted ? 'text-muted' : '';
@endphp

<label
    @if($for) for="{{ $for }}" @endif
    {{ $attributes->merge(['class' => $classes]) }}
>
    @if($size === 'sm')
        <small class="{{ $mutedClass }}">
            {{ $value ?? $slot }}
        </small>
    @else
        <span class="{{ trim("$textClass $mutedClass") }}">
            {{ $value ?? $slot }}
        </span>
    @endif
</label>
