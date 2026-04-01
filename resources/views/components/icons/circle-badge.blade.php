@props([
    'type' => 'active', 
    'size' => 'sm'
])

@php
    $classes = match($type) {
        'active' => [
            'bg' => 'bg-success-soft border-success-subtle text-fg-success-strong',
            'icon' => 'M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
        ],
        'near-expiry' => [
            'bg' => 'bg-warning-soft border-warning-subtle text-fg-warning',
            'icon' => 'M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z', 
        ],
        'expired' => [
            'bg' => 'bg-danger-soft border-danger-subtle text-fg-danger-strong',
            'icon' => 'M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z', 
        ],
        default => [
            'bg' => 'bg-gray-100 border-gray-200 text-gray-500',
            'icon' => 'M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
        ],
    };

    $sizeClasses = match($size) {
        'lg' => 'h-8 w-8',
        'sm' => 'h-5 w-5',
        'md' => 'h-6 w-6',
        default => 'h-5 w-5',
    };
@endphp

<span {{ $attributes->merge(['class' => "flex items-center p-1 justify-center border font-medium rounded-full $sizeClasses " . $classes['bg']]) }}>
    <svg class="$sizeClasses" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $classes['icon'] }}"/>
    </svg>
</span>