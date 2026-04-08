@props(['warranty'])

<div class="flex flex-col lg:flex-row my-6 w-full p-5 rounded-md border overflow-hidden border-gray-300 bg-white">
    <div class="w-full lg:w-2/5 shrink-0">
        <div class="relative group cursor-pointer rounded-md border border-gray-300 overflow-hidden">
            <div class="aspect-square md:aspect-video lg:aspect-square w-full flex items-center justify-center p-6">
                <img src="{{ $warranty->product->image_url }}" alt="{{ $warranty->product->name }}"
                    class="w-full h-full object-contain mix-blend-multiply" />
            </div>
        </div>
    </div>
    <div class="flex-1 lg:pl-6 py-4 flex flex-col space-y-6">
        <div>
            <h1 class="text-neutral-500">Product Name</h1>
            <p class="text-2xl text-neutral-900 font-bold">{{ $warranty->product->name }}</p>
        </div>

        <div>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <h1 class="text-neutral-500 text-sm">Category</h1>
                    <p class="text-md text-neutral-900 font-semibold">{{ $warranty->product->category }}</p>
                </div>
                <div class="block">
                    <h1 class="text-neutral-500 text-sm">Warranty Status</h1>
                    <x-icons.badge type="{{ $warranty->status }}" size="sm">
                        {{ $warranty->status->label() }}
                    </x-icons.badge>
                </div>

                <div>
                    <h1 class="text-neutral-500 text-sm">Date Purchased</h1>
                    <p class="text-md text-neutral-900 font-semibold">
                        {{ $warranty->purchase_date->format('M d, Y') }}</p>
                </div>
                <div>
                    <h1 class="text-neutral-500 text-sm">Warranty Expiration</h1>
                    <p class="text-md text-neutral-900 font-semibold">{{ $warranty->expiry_date->format('M d, Y') }}
                    </p>
                </div>

                <div>
                    <h1 class="text-neutral-500 text-sm">Service Center Name</h1>
                    <p class="text-md text-neutral-900 font-semibold">
                        {{ $warranty->product->service_center_name }}</p>
                </div>
                <div>
                    <h1 class="text-neutral-500 text-sm">Service Center Address</h1>
                    <p class="text-md text-neutral-900 font-semibold">{{ $warranty->product->service_center_address }}
                    </p>
                </div>

                <div>
                    <h1 class="text-neutral-500 text-sm">Serial Number</h1>
                    <p class="text-md text-neutral-900 font-semibold">{{ $warranty->serial_number }}</p>
                </div>

                <div class="col-span-2 border-t border-gray-300 pt-4 mt-2">
                    <h1 class="text-neutral-500 text-md">Coverage</h1>
                    <div class="flex items-center space-x-2 mt-2">
                        @if ($warranty->expiry_date->isPast())
                            <x-icons.circle-badge type="{{ $warranty->status }}" size="lg" />
                            <h1 class="text-fg-danger-strong text-lg font-semibold">Expired</h1>
                        @else
                            <x-icons.circle-badge type="{{ $warranty->status }}" size="lg" />
                            <p class="text-md text-neutral-900 font-semibold">
                                {{ (int) now()->diffInDays($warranty->expiry_date) }} Days Left</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
