@props([
    'name',
    'options' => [],
    'selected' => null,
    'placeholder' => null,
    'valueField' => null,
    'labelField' => null
])

<select name="{{ $name }}" id="{{ $attributes->get('id') ?? $name }}"
    {{ $attributes->merge(['class' => 'rounded-md border-gray-300 text-sm focus:ring-neutral-900 focus:border-neutral-900']) }}>

    @if ($placeholder)
        <option value="">{{ $placeholder }}</option>
    @endif

    @foreach ($options as $key => $label)
        @php
            $value = $valueField ? $label->$valueField : $key;
            $displayLabel = $labelField ? $label->$labelField : $label;
        @endphp
        <option value="{{ $value }}" @selected($selected == $value)>
            {{ $displayLabel }}
        </option>
    @endforeach
</select>