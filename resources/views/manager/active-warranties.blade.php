<x-admin-layout title="Active Warranties" subtitle="View all active warranties, their customers, and status details.">
    <div class="mt-6 bg-white border border-gray-300 rounded-md overflow-hidden">
        <x-ui.manager.table-search route="active-warranties" statusRoute="active-warranties" placeholder="Search product name, customer, serial number" :select="$select" />
        <div class="overflow-x-auto">
            @php
                $headers = ['Products', 'Customer', 'Serial Number', 'Status', 'Purchase Date', 'Warranty Duration'];
            @endphp
            <x-ui.manager.table :headers="$headers" :action="true" :datas="$warranties">
                @forelse ($warranties as $warranty)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <div class="h-10 w-10 shrink-0">
                                    <img class="h-10 w-10 rounded-md object-cover border border-gray-200"
                                        src="{{ $warranty->product->image_url }}" alt="Product">
                                </div>
                                <div class="text-sm font-semibold text-gray-900">
                                    {{ $warranty->product->name }}</div>
                            </div>
                        </td>
                        <td class="table-text">
                            @if ($warranty->user_id)
                                <div class="flex items-center space-x-2">
                                    <x-icons.avatar :name="$warranty->user->name" size="sm" />
                                    <span>{{ $warranty->user->name }}</span>
                                </div>
                            @else
                                <x-icons.avatar name="NA" size="sm" />
                                <span>Not Claimed Yet</span>
                            @endif
                        </td>
                        <td class="table-text">
                            {{ $warranty->serial_number }}</td>
                        <td class="table-text">
                            <x-icons.badge type="{{ $warranty->status }}" size="sm">
                                {{ $warranty->status->label() }}
                            </x-icons.badge>
                        </td>
                        <td class="table-text">
                            {{ $warranty->purchase_date->format('M d, Y') }}</td>
                        <td class="table-text">
                            @if ($warranty->expiry_date->isPast())
                                <p class="text-[12px] tracking-wide text-fg-danger-strong font-medium">Expired</p>
                                <p class="text-sm font-semibold text-fg-danger-strong whitespace-nowrap">
                                    {{ $warranty->expiry_date->format('M d, Y') }}
                                </p>
                            @else
                                <p class="text-[12px] tracking-wide text-neutral-500 font-medium">Expires In</p>
                                <p class="text-sm font-semibold text-neutral-900 whitespace-nowrap">
                                    {{ (int) now()->diffInDays($warranty->expiry_date) }} days
                                </p>
                            @endif
                        </td>
                        <td class="px-6 text-right py-4 whitespace-nowrap text-sm text-neutral-900">
                            <button
                                class="text-gray-400 hover:text-gray-600 transition p-2 rounded-full hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="1"></circle>
                                    <circle cx="19" cy="12" r="1"></circle>
                                    <circle cx="5" cy="12" r="1"></circle>
                                </svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    @php
                        $hasFilters = request()->filled('search') || request()->filled('status');
                    @endphp
                    <tr>
                        <td colspan="7" class="px-4 py-35 text-center text-neutral-500">
                            @if ($hasFilters)
                                <x-ui.is-empty title="No matching warranties found"
                                    subTitle="Try adjusting your search or filter criteria" />
                            @else
                                <x-ui.is-empty title="No active warranties"
                                    subTitle="Register a customers product warranties" />
                                <a href="{{ route('register-warranty') }}"
                                    class="inline-block mt-6 items-center px-4 py-3 bg-neutral-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black/80 focus:outline-none transition ease-in-out duration-150">
                                    REGISTER WARRANTIES
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforelse
            </x-ui.manager.table>
        </div>
    </div>
</x-admin-layout>
