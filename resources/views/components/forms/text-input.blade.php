@props(['disabled' => false, 'icon' => false])

<div class="relative w-full group">
    <input 
        @disabled($disabled) 
        {{ $attributes->merge([
            'class' => 'font-normal w-full py-2 bg-white border focus:outline-none border-gray-300 focus:border-neutral-800 focus:ring focus:ring-neutral-800 rounded-md transition-all ' . ($icon ? 'pl-10 pr-3' : 'px-3')
        ]) }}
    >
</div>