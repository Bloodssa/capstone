@props(['data', 'product'])

<x-modals.products.modal :data="$data">

    <div class="mb-6">
        <h4 class="text-xl text-neutral-900 font-semibold">Product Details</h4>
        <p class="text-sm text-neutral-500">View complete product information</p>
    </div>

    <div class="mb-6">
        <div class="border border-gray-300 rounded-md overflow-hidden">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                class="w-full h-64 object-contain bg-gray-50">
        </div>
    </div>

    <div class="border border-gray-300 rounded-md divide-y divide-gray-300">

        <div class="p-4">
            <p class="text-sm text-neutral-500">Product Name</p>
            <p class="text-neutral-900 font-semibold">{{ $product->name }}</p>
        </div>

        <div class="p-4">
            <p class="text-sm text-neutral-500">Category</p>
            <p class="text-neutral-900 font-semibold">{{ $product->category }}</p>
        </div>

        <div class="p-4">
            <p class="text-sm text-neutral-500">Brand</p>
            <p class="text-neutral-900 font-semibold">{{ $product->brand }}</p>
        </div>

        <div class="p-4">
            <p class="text-sm text-neutral-500">Warranty Duration</p>
            <p class="text-neutral-900 font-semibold">{{ $product->warranty_duration }} months</p>
        </div>

    </div>

    <div class="mt-6 border border-gray-300 rounded-md divide-y divide-gray-300">

        <div class="p-4">
            <p class="text-sm text-neutral-500">Service Center Name</p>
            <p class="text-neutral-900 font-semibold">{{ $product->service_center_name }}</p>
        </div>

        <div class="p-4">
            <p class="text-sm text-neutral-500">Service Center Address</p>
            <p class="text-neutral-900 font-semibold">{{ $product->service_center_address }}</p>
        </div>

    </div>

    <div class="mt-6 flex justify-end">
        <button @click="{{ $data }} = false"
            class="px-6 py-2 border border-gray-300 rounded-md text-neutral-900 hover:bg-gray-50">
            Close
        </button>
    </div>
</x-modals.products.modal>
