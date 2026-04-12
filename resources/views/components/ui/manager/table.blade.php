@props([
    'headers' => null,
    'action' => false,
    'datas' => [],
    'borderTop' => true
])
<div>
    <table {{ $attributes->merge(['class' => 'min-w-full divide-y divide-gray-300 ' . ($borderTop ? 'border-t border-gray-300' : '')]) }}>
        <thead>
            <tr>
                @foreach ($headers as $header)
                    <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-neutral-900">
                        {{ ucfirst($header) }}
                    </th>
                @endforeach
                @if ($action)
                    <th scope="col" class="px-6 py-3 text-right text-sm font-semibold text-neutral-900">
                        Actions
                    </th>
                @endif
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-300">
            {{ $slot }}
        </tbody>
    </table>
    @if (method_exists($datas, 'hasPages') && $datas->hasPages())
        <div class="px-3 py-2 w-full border-t border-gray-300">
            {{ $datas->links() }}
        </div>
    @endif
</div>