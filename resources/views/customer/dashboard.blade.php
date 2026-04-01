<x-app-layout>

    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-900">
            Hello, {{ Str::before(Auth::user()->name, ' ') ?? 'Guest' }}
        </h1>
        <p class="text-neutral-500 mt-2 text-md">Monitor your warranties, track claims, and never miss an expiration
            date.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-ui.customer.summary color="emerald" :count="$activeWarranties" title="Active Warranties" :url="route('warranty')"
            icon="M438-226 296-368l58-58 84 84 168-168 58 58-226 226ZM200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Z" />
        <x-ui.customer.summary color="amber" :count="$expWarCount" title="Expiring Soon" :url="route('warranty')"
            icon="M593-567q47-47 47-113v-120H320v120q0 66 47 113t113 47q66 0 113-47ZM160-80v-80h80v-120q0-61 28.5-114.5T348-480q-51-32-79.5-85.5T240-680v-120h-80v-80h640v80h-80v120q0 61-28.5 114.5T612-480q51 32 79.5 85.5T720-280v120h80v80H160Z" />
        <x-ui.customer.summary color="blue" :count="0" title="Resolved Claims" :url="route('warranty')"
            icon="M480-400ZM80-160v-400q0-33 23.5-56.5T160-640h120v-80q0-33 23.5-56.5T360-800h240q33 0 56.5 23.5T680-720v80h120q33 0 56.5 23.5T880-560v400H80Zm240-200v40h-80v-40h-80v120h640v-120h-80v40h-80v-40H320ZM160-560v120h80v-40h80v40h320v-40h80v40h80v-120H160Zm200-80h240v-80H360v80Z" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 mt-10 gap-6">

        <div class="border border-gray-300 bg-white rounded-md flex flex-col">
            <div class="px-4 py-3 border-b border-gray-300">
                <h1 class="text-neutral-900 font-semibold text-md">Recent Purchase</h1>
            </div>

            <div @class([
                'divide-y divide-gray-300',
                'py-10 flex flex-col items-center justify-center' => $recentlyPurchased->isEmpty(),
            ])>
                @forelse($recentlyPurchased as $purchased)
                    <div class="flex flex-row p-3">
                        <div class="w-16 h-16 bg-white border border-gray-100 rounded-md overflow-hidden shrink-0">
                            <img src="{{ $purchased->product->image_url }}" alt="{{ $purchased->product->name }}"
                                class="w-full h-full object-cover" />
                        </div>
                        <div class="flex-1 ml-4 flex justify-between items-center">
                            <div>
                                <h1 class="text-neutral-900 text-md font-semibold">{{ $purchased->product->name }}</h1>
                                <p class="text-neutral-500 text-sm">Purchased:
                                    {{ $purchased->purchase_date->format('M d, Y') }}</p>
                            </div>
                            <a href="{{ route('warranty.show', $purchased->id) }}"
                                class="text-sm text-neutral-900 hover:underline font-medium">Details</a>
                        </div>
                    </div>
                @empty
                    <x-ui.is-empty title="No recently purchased product"
                        subTitle="Purchase to our shop for product warranty" />
                @endforelse
            </div>
        </div>

        <div class="border border-gray-300 bg-white rounded-md flex flex-col">
            <div class="px-4 py-3 border-b border-gray-300">
                <h1 class="text-neutral-900 font-semibold text-md">Expiring Warranties</h1>
            </div>

            <div @class([
                'divide-y divide-gray-300',
                'py-10 flex flex-col items-center justify-center' => $expiringWarranties->isEmpty(),
            ])>
                @forelse($expiringWarranties as $expWarranty)
                    <div class="flex flex-row p-3">
                        <div class="w-16 h-16 bg-white border border-gray-100 rounded-md overflow-hidden shrink-0">
                            <img src="{{ $expWarranty->product->image_url }}" alt="{{ $expWarranty->product->name }}"
                                class="w-full h-full object-cover" />
                        </div>
                        <div class="flex-1 ml-4 flex justify-between items-center">
                            <div>
                                <h1 class="text-neutral-900 text-md font-semibold">{{ $expWarranty->product->name }}
                                </h1>
                                <p class="text-neutral-500 text-sm">Serial: {{ $expWarranty->serial_number }}</p>
                            </div>
                            <div class="text-right">
                                @if ($expWarranty->status === 'near-expiry')
                                    <h1 class="text-neutral-900 text-xs">Expires in</h1>
                                    <p class="text-neutral-900 text-lg font-bold">
                                        {{ (int) now()->diffInDays($expWarranty->expiry_date) }} Days
                                    </p>
                                @else
                                    <h1 class="text-red-500 text-xl font-semibold">Expired</h1>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <x-ui.is-empty title="No purchased product" subTitle="No product near-expiry or expired" />
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
