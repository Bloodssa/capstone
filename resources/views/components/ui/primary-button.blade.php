<button {{ $attributes->merge(['type' => 'submit', 'class' => 'items-center px-4 py-3 bg-neutral-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black/80 focus:outline-none transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
