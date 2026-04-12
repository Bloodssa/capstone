@props(['active' => false])

@php 
    $class = $active ? 'group flex items-center gap-3 rounded-md py-2.5 px-3 font-semibold text-neutral-900 bg-gray-100 transition-all'
                     : 'group flex items-center gap-3 rounded-md py-2.5 px-3 font-semibold text-neutral-500 hover:bg-gray-100 hover:text-neutral-900 transition-all'
@endphp

<a {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</a>
