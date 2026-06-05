@props([
    'size' => null, 
])

@php
    $classes = "";

    if ($size) {
        $parts = explode(' ', $size);

        foreach ($parts as $part) {
            if (str_contains($part, '-')) {
                [$col, $bp] = explode('-', $part); 
                $classes .= " col-$bp-$col";
            } else {
                $classes .= " col-$part";
            }
        }
    }
@endphp

<div {{ $attributes->merge(['class' => trim($classes) . ' text-center']) }}>
    {{ $slot }}
</div>