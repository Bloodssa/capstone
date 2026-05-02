<form method="POST" action="{{ route('store-product') }}" class="space-y-6" enctype="multipart/form-data">
    @csrf
    <x-modals.products.product-form :categories="$categories" />
    <div class="flex flex-col sm:flex-row justify-end gap-3">
        <x-ui.primary-button class="w-full sm:w-auto justify-center whitespace-nowrap">
            Add Product
        </x-ui.primary-button>
    </div>
</form>
