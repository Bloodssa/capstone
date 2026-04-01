@props([
    'name' => 'Guest',
    'size' => 'md'
])

@php
    $sizes = match($size) {
        'xs' => 'w-6 h-6 text-xs',
        'sm' => 'w-8 h-8 text-sm',
        'md' => 'w-10 h-10 text-base',
        'lg' => 'w-12 h-12 text-lg',
        default => 'w-10 h-10 text-base',
    };
    $firstLetter = Str::upper(Str::substr($name, 0, 1)) ?: 'G';
@endphp

<div {{ $attributes->merge(['class' => "relative cursor-pointer inline-flex items-center justify-center overflow-hidden bg-blue-900 rounded-full shrink-0 $sizes"]) }}>
    <span class="font-semibold text-white leading-none">
        {{ $firstLetter }}
    </span>
</div>