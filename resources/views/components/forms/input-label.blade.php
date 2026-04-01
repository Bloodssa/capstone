@props(['value', 'hasError' => false])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm' . ($hasError ? 'text-red-600' : 'text-neutral-900')]) }}>
    {{ $value ?? $slot }}
</label>
