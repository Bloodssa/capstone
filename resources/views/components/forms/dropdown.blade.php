@props([
    'value' => null,
])

<select 
    {{ $attributes->merge([
        'class' => 'font-normal w-full border-gray-300 focus:border-neutral-800 focus:ring-neutral-800 rounded-md py-3 px-3 text-sm'
    ]) }}
>
    <option value="Laptop" {{ $value == 'Laptop' ? 'selected' : '' }}>Laptop</option>
    <option value="Desktop" {{ $value == 'Desktop' ? 'selected' : '' }}>Desktop</option>
    <option value="Monitor" {{ $value == 'Monitor' ? 'selected' : '' }}>Monitor</option>
    <option value="Component" {{ $value == 'Component' ? 'selected' : '' }}>Component</option>
</select>