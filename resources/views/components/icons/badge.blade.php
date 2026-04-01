@props([
    'type' => 'active',
    'size' => 'sm'
])

@php
    $types = [
        'active' => 'bg-success-soft border-success-subtle text-fg-success-strong',
        'near-expiry' => 'bg-warning-soft border-warning-subtle text-fg-warning',
        'expired' => 'bg-danger-soft border-danger-subtle text-fg-danger-strong',
    ];

    $dots = [
        'active' => 'bg-fg-success-strong',
        'near-expiry' => 'bg-fg-warning',
        'expired' => 'bg-fg-danger-strong',
    ];

    $sizes = [
        'sm' => 'px-1.5 py-0.5 text-xs',
        'md' => 'px-2.5 py-1 text-sm',
        'lg' => 'px-3 py-1.5 text-base',
    ];

    $dotSizes = [
        'sm' => 'h-1.5 w-1.5',
        'md' => 'h-2 w-2',
        'lg' => 'h-2.5 w-2.5',
    ];

    $classes = "inline-flex items-center border font-medium rounded " . ($types[$type] ?? $types['active']) . " " . ($sizes[$size] ?? $sizes['sm']);
    $dotClasses = "rounded-full me-1.5 " . ($dots[$type] ?? $dots['active']) . " " . ($dotSizes[$size] ?? $dotSizes['sm']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    <span class="{{ $dotClasses }}"></span>
    {{ $slot }}
</span>