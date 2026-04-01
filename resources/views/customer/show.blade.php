<x-app-layout>
    <h1 class="font-semibold text-neutral-900 text-2xl">Warranty Records</h1>
    @if (session('success'))
        <x-ui.toast type="success" message="{{ session('success') }}" />
    @endif

    <x-ui.customer.product-details :warranty="$warranty" />

    <x-ui.customer.discussion :warranty="$warranty" />

    <h1 class="font-semibold text-neutral-900 text-xl mt-8">Repair and Services History</h1>
    <div class="w-full rounded-md border overflow-hidden border-gray-300 bg-white oveflow-hidden mt-2">
        <table class="w-full text-left border-collapse">
            <thead class="bg-white border-b border-gray-300">
                <tr>
                    <th class="px-6 py-3 text-md font-semibold text-neutral-900">Date</th>
                    <th class="px-6 py-3 text-md font-semibold text-neutral-900">Hardware Issue</th>
                    <th class="px-6 py-3 text-md font-semibold text-neutral-900">Action Taken</th>
                    <th class="px-6 py-3 text-md font-semibold text-neutral-900 text-right">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-300">
                <tr>
                    <td class="px-6 py-4 text-sm text-neutral-600">March 12, 2025</td>
                    <td class="px-6 py-4 text-sm font-medium text-neutral-900">Screen Flickering</td>
                    <td class="px-6 py-4 text-sm text-neutral-500">LCD Replacement</td>
                    <td class="px-6 py-4 text-right">
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Resolved</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</x-app-layout>
