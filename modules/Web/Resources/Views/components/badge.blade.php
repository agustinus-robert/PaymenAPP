@props(['variant' => 'primary', 'size' => 'default'])

@php
    $base = 'text-xs font-medium me-2 w-fit';
    $variant = match ($variant) {
        default => 'bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-300',
        'destructive' => 'bg-destructive-100 text-destructive-800 dark:bg-destructive-900 dark:text-destructive-300',
        'success' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
        'secondary' => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300',
    };

    $size = match ($size) {
        default => 'px-2.5 py-0.5 rounded',
        'sm' => 'px-2 rounded-sm',
    };

    $classes = $base . ' ' . $variant . ' ' . $size;
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
