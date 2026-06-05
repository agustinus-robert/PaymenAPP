@props(['type' => 'button', 'variant' => 'primary', 'size' => 'default'])

@php
    $base =
        'inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50';
    $variant = match ($variant) {
        default => 'bg-primary text-primary-foreground hover:bg-primary/90',
        'destructive' => 'bg-destructive text-destructive-foreground hover:bg-destructive/90',
        'outline' => 'border border-input bg-transparent hover:bg-accent hover:text-accent-foreground',
        'secondary' => 'bg-secondary text-secondary-foreground hover:bg-secondary/80',
        'ghost' => 'hover:bg-accent hover:text-accent-foreground',
        'link' => 'text-primary underline-offset-4 hover:underline',
    };

    $size = match ($size) {
        default => 'h-10 px-6 py-2',
        'sm' => 'h-9 rounded-md px-4',
        'xs' => 'h-8 rounded-md px-3',
        'lg' => 'h-11 rounded-md px-9',
        'icon' => 'h-10 w-10',
        'iconSm' => 'h-8 w-8',
    };

    $classes = $base . ' ' . $variant . ' ' . $size;
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
