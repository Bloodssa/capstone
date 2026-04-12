@props([
    'path',
    'active' => false,
    'size' => 'w-5 h-5',
    'viewBox' => '0 0 24 24',
    'activeColor' => 'text-neutral-900',
    'inactiveColor' => 'text-neutral-500 group-hover:text-neutral-900',
])

@php
    $classes = $size . ' transition-colors ' . ($active ? $activeColor : $inactiveColor);
@endphp

<svg fill="currentColor" viewBox="{{ $viewBox }}" {{ $attributes->merge(['class' => $classes]) }}>
    <path d="{{ $path }}" />
</svg>
