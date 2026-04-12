<x-app-layout>
    <div class="flex items-center gap-2">
        <div class="relative flex-1 group">
            <div
                class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-neutral-500 group-focus-within:text-gray-600 z-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-neutral-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <x-forms.search-form route="warranty" />
        </div>
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open"
                class="p-2 flex space-x-2 font-semibold text-neutral-900 border border-gray-300 rounded-md bg-white hover:bg-gray-200 transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                <span>Filter By Status</span>
            </button>
            <div x-show="open" @click.away="open = false" x-transition
                class="absolute border border-gray-300 overflow-hidden right-0 mt-2 w-48 bg-white rounded-md z-50">
                @php
                    $status = request('status');
                @endphp
                <a href="{{ route('warranty', ['search' => request('search')]) }}"
                    class="block px-4 py-2 text-sm text-neutral-900 hover:bg-gray-100 {{ !$status ? 'bg-gray-100 font-semibold' : 'hover:bg-gray-100' }}">
                    All
                </a>
                <a href="{{ route('warranty', ['status' => 'active', 'search' => request('search')]) }}"
                    class="block px-4 py-2 text-sm text-neutral-900 {{ $status === 'active' ? 'bg-gray-100 font-semibold' : 'hover:bg-gray-100' }}">
                    Active
                </a>
                <a href="{{ route('warranty', ['status' => 'near_expiry', 'search' => request('search')]) }}"
                    class="block px-4 py-2 text-sm text-neutral-900 hover:bg-gray-100 {{ $status === 'near_expiry' ? 'bg-gray-100 font-semibold' : 'hover:bg-gray-100' }}">
                    Near Expiry
                </a>
                <a href="{{ route('warranty', ['status' => 'expired', 'search' => request('search')]) }}"
                    class="block px-4 py-2 text-sm text-neutral-900 hover:bg-gray-100 {{ $status === 'expired' ? 'bg-gray-100 font-semibold' : 'hover:bg-gray-100' }}">
                    Expired
                </a>
            </div>
        </div>
    </div>
    <h1 class="my-5 font-semibold text-gray-900">Warranties</h1>
    <div class="border border-gray-300 rounded-md overflow-hidden bg-white">
        <table class="w-full border-collapse">
            <tbody class="divide-y divide-gray-300">
                @forelse ($warranties as $warranty)
                    <tr class="cursor-pointer"
                        onclick="window.location.href='{{ route('warranty.show', $warranty->id) }}'">
                        <td class="px-4 py-3 align-middle">
                            <div class="flex items-center gap-4 min-w-0">
                                <img src="{{ $warranty->product->image_url }}" alt="{{ $warranty->product->name }}"
                                    class="w-15 h-15 rounded-md object-cover border border-gray-300 shrink-0" />
                                <div class="min-w-0 space-y-2">
                                    <p class="text-md font-semibold text-neutral-900 truncate">
                                        {{ $warranty->product->name }}
                                    </p>
                                    <p class="text-xs text-neutral-500 truncate">
                                        Serial Number: {{ $warranty->serial_number }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="hidden lg:table-cell px-4 py-3 align-middle">
                            <div class="min-w-0 space-y-2">
                                <p class="text-sm text-neutral-900 font-semibold truncate">
                                    {{ $warranty->product->category }}
                                </p>
                                <p class="text-xs text-neutral-500 whitespace-nowrap">
                                    Purchased {{ $warranty->purchase_date->format('M d, Y') }}
                                </p>
                            </div>
                        </td>
                        <td class="px-4 py-3 align-middle text-right">
                            <div class="space-y-2">
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
                            </div>
                        </td>
                        <td class="px-4 py-3 align-middle text-right w-40">
                            <div class="inline-flex w-full justify-end">
                                <x-icons.badge type="{{ $warranty->status }}" size="md"
                                    class="w-32 justify-center">
                                    {{ Str::title($warranty->status->label()) }}
                                </x-icons.badge>
                            </div>
                        </td>
                        <td class="px-4 py-3 align-middle text-right w-12">
                            <button onclick="event.stopPropagation()"
                                class="p-1.5 rounded-md text-neutral-500 hover:text-neutral-900 transition"
                                aria-label="Actions">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @empty
                @php
                    $hasFilters = request('search') || request('status');
                @endphp
                    <tr>
                        <td colspan="5" class="px-4 py-35 text-center text-neutral-500">
                            @if ($hasFilters)
                                <x-ui.is-empty title="No matching warranties found" subTitle="Try adjusting your search or filter criteria" />
                            @else
                                <x-ui.is-empty title="No warranties yet" subTitle="You haven’t purchased any products with warranty coverage yet" />
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $warranties->links() }}
    </div>
</x-app-layout>
