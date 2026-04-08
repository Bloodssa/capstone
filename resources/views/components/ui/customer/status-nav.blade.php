@props([ 'icon' => false, 'first' => false, 'name', 'href' => '#', 'active' => false ])

<li {{ $attributes->merge([
    'class' => $first ? 'inline-flex items-center' : ''
]) }}>
    <div class="flex items-center space-x-1.5">
        
        @if ($icon && !$first)
            <svg class="w-3.5 h-3.5 rtl:rotate-180 text-neutral-500"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m9 5 7 7-7 7"/>
            </svg>
        @endif

        <a href="{{ $href }}"
            @class([
                'inline-flex items-center text-sm font-medium transition-colors',
                'text-neutral-500 hover:text-neutral-900' => !$active,
                'text-neutral-900 font-semibold' => $active
            ])
            @if($active) aria-current="page" @endif
        >
            {{ $name }}
        </a>

    </div>
</li>