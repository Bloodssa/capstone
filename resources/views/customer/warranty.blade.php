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

            <x-forms.text-input type="text" :icon="true" placeholder="Search Warranties..." />
        </div>

        <button
            class="p-2 border border-gray-300 rounded-md text-neutral-500 bg-white hover:bg-gray-200 transition-colors duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 text-neutral-900 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
        </button>

        <div class="flex p-1 bg-white border border-gray-300 rounded-md">
            <button class="p-1.5 bg-white shadow-sm border border-gray-100 rounded text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
            </button>
            <button class="p-1.5 text-gray-400 hover:text-gray-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    <h1 class="my-5 font-semibold text-gray-900">Warranties</h1>

    <nav class="flex mb-4 ml-2" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2">
            <x-ui.customer.status-nav :first="true" name="All" href="{{ '' }}" />
            <x-ui.customer.status-nav :icon="true" name="Active" href="{{ '' }}" />
            <x-ui.customer.status-nav :icon="true" name="Near Expiry" href="{{ '' }}" />
            <x-ui.customer.status-nav :icon="true" name="Expired" href="{{ '' }}" />
        </ol>
    </nav>

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
                    <tr>
                        <td colspan="5" class="px-4 py-35 text-center text-neutral-500">
                            <x-ui.is-empty title="No purchased product"
                                subTitle="Purchase to our shop for product warranty" />
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-app-layout>
