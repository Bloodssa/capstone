@props([
    'title',
    'expiring' => false,
    'isEmpty' => true,
    'products',
    'emptyTitle' => 'No recently purchased product',
    'emptySubTitle' => 'Purchase to our shop for product warranty',
])

<div class="border border-gray-300 bg-white rounded-md flex flex-col">
    <div class="px-4 py-3 border-b border-gray-300">
        <h1 class="text-neutral-900 font-semibold text-md">{{ $title }}</h1>
    </div>
    <div @class([
        'divide-y divide-gray-300',
        'py-10 flex flex-col items-center justify-center' => $isEmpty,
    ])>
        @forelse($products as $product)
            <div class="flex flex-row p-3">
                <div class="w-16 h-16 bg-white border border-gray-100 rounded-md overflow-hidden shrink-0">
                    <img src="{{ $product->product->image_url }}" alt="{{ $product->product->name }}"
                        class="w-full h-full object-cover" />
                </div>
                <div class="flex-1 ml-4 flex justify-between items-center">
                    <div>
                        <h1 class="text-neutral-900 text-md font-semibold">{{ $product->product->name }}</h1>
                        <p class="text-neutral-500 text-sm">Purchased:
                            {{ $product->purchase_date->format('M d, Y') }}</p>
                    </div>
                    @if ($expiring)
                        <div>
                            <div class="text-right">
                                @if ($product->status === \App\Enum\WarrantyStatusType::NEAR_EXPIRY)
                                    <h1 class="text-neutral-900 text-xs">Expires in</h1>
                                    <p class="text-neutral-900 text-lg font-bold">
                                        {{ (int) now()->diffInDays($product->expiry_date) }} Days
                                    </p>
                                @else
                                    <h1 class="text-red-500 text-xl font-semibold">Expired</h1>
                                @endif
                            </div>
                        </div>
                    @else
                        <a href="{{ route('warranty.show', $product->id) }}"
                            class="text-sm text-neutral-900 hover:underline font-medium">Details</a>
                    @endif
                </div>
            </div>
        @empty
            <x-ui.is-empty title="{{ $emptyTitle }}" subTitle="{{ $emptySubTitle }}" />
        @endforelse
    </div>
</div>
