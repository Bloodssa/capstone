@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full px-3 py-2 border focus:outline-none border-gray-300 focus:border-theme-hover focus:ring-1 focus:ring-theme-hover rounded-md shadow-sm']) }}>
