@props(['disabled' => false])

<div class="relative w-full">
    <textarea 
        @disabled($disabled) 
        rows="1"
        oninput='this.style.height = ""; this.style.height = this.scrollHeight + "px"'
        {{ $attributes->merge([
            'class' => 'w-full py-2 bg-white border border-gray-300 rounded-md outline-none transition-all focus:border-neutral-800 focus:ring-1 focus:ring-neutral-800 disabled:bg-gray-50 disabled:text-gray-500 px-3 overflow-hidden resize-none min-h-[42px]' 
        ]) }}
    ></textarea>
</div>