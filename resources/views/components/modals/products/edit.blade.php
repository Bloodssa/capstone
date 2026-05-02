@props(['data', 'product', 'categories'])

<x-modals.products.modal :data="$data">
    <div class="mb-8">
        <h4 class="text-[24px] font-semibold text-gray-800">Edit Product</h4>
        <p class="text-sm text-gray-500">Modify the product details, pricing, and availability.</p>
    </div>

    <form method="POST" action="{{ route('update-product', $product->id) }}" class="space-y-6"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        
        <x-modals.products.product-form :product="$product" :categories="$categories" />
        <div class="flex flex-col sm:flex-row justify-end gap-3">
            <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 mt-4">
                <button @click="{{ $data }} = false"
                    class="px-6 py-2 border border-gray-300 rounded-md text-neutral-900 hover:bg-gray-50">
                    Close
                </button>
                <x-ui.primary-button class="w-full sm:w-auto justify-center whitespace-nowrap">
                    Update Product
                </x-ui.primary-button>
            </div>
        </div>
    </form>
</x-modals.products.modal>
