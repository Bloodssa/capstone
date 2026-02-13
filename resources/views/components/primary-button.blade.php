<button {{ $attributes->merge(['type' => 'submit', 'class' => 'items-center px-4 py-3 bg-theme-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-hover focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
