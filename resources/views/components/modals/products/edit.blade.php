@props(['data', 'product', 'categories'])

<x-modals.products.modal :data="$data">
    <div class="mb-8">
        <h4 class="text-[24px] font-semibold text-gray-800">Edit Product</h4>
        <p class="text-sm text-gray-500">Modify the product details, pricing, and availability.</p>
    </div>

    <form method="POST" action="{{ route('update-product', $product->id) }}" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white border border-gray-300 rounded-md overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-300">
                <h1 class="text-neutral-900 text-lg font-semibold">Product Specification</h1>
            </div>
            <div class="px-4 sm:px-6 py-3 sm:py-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                    <div class="space-y-1">
                        <x-forms.input-label for="product_name" :hasError="$errors->has('name')" :value="__('Product Name')" />
                        <x-forms.text-input id="product_name" name="name" :value="old('name', $product->name)"
                            class="w-full {{ $errors->has('name') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '' }}"
                            placeholder="e.g. ROG Zephyrus M16" />
                        <x-forms.input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="space-y-1">
                        <x-forms.input-label for="category" :hasError="$errors->has('category')" :value="__('Category')" />
                        <x-forms.select name="category" :options="$categories" placeholder="Select Category" :selected="request('status')" class="w-full" />
                        <x-forms.input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>
                    <div class="space-y-1">
                        <x-forms.input-label for="brand" :hasError="$errors->has('brand')" :value="__('Brand')" />
                        <x-forms.text-input id="brand" name="brand" :value="old('brand', $product->brand)"
                            class="w-full {{ $errors->has('brand') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '' }}"
                            placeholder="Enter product manufacturer/brand" />
                        <x-forms.input-error :messages="$errors->get('brand')" class="mt-2" />
                    </div>
                    <div class="space-y-1">
                        <x-forms.input-label for="warranty_duration" :value="__('Warranty Duration')" />
                        <x-forms.text-input type="number" id="warranty_duration" :value="old('warranty_duration', $product->warranty_duration)"
                            name="warranty_duration"
                            class="w-full {{ $errors->has('warranty_duration') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '' }}"
                            placeholder="Enter number of months" />
                        <x-forms.input-error :messages="$errors->get('warranty_duration')" class="mt-2" />
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-6" x-data="{
            imageUrl: '{{ asset('storage/' . $product->product_image_url) }}',
            imageUpdate(event) {
                const file = event.target.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = e => {
                    this.imageUrl = e.target.result;
                }
            }
        }">
        
            <div class="relative group border border-gray-300 rounded-md overflow-hidden">
                <img :src="imageUrl" alt="{{ $product->name }}" class="w-full h-64 object-contain bg-gray-50">
                <div @click.stop
                    class="absolute inset-0 bg-gray/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <label for="update_image_{{ $product->id }}" class="cursor-pointer py-3 px-6 bg-neutral-900 hover:bg-neutral-900/90 text-white font-semibold rounded-md">
                        Update Image
                    </label>

                    <input type="file" id="update_image_{{ $product->id }}" name="product_image_url" accept="image/*" @change="imageUpdate" class="hidden" />
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-300 rounded-md overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-300">
                <h1 class="text-neutral-900 text-lg font-semibold">Service Center</h1>
            </div>
            <div class="px-4 sm:px-6 py-3 sm:py-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                    <div class="space-y-1">
                        <x-forms.input-label for="service_center_name" :hasError="$errors->has('service_center_name')" :value="__('Service Center Name')" />
                        <x-forms.text-input id="service_center_name" name="service_center_name" :value="old('service_center_name', $product->service_center_name)"
                            class="w-full {{ $errors->has('service_center_name') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '' }}"
                            placeholder="GravStar Service Center Cebu" />
                        <x-forms.input-error :messages="$errors->get('service_center_name')" class="mt-2" />
                    </div>
                    <div class="space-y-1">
                        <x-forms.input-label for="service_center_address" :hasError="$errors->has('service_center_address')" :value="__('Service Center Name')" />
                        <x-forms.text-input id="service_center_address" name="service_center_address" :value="old('service_center_address', $product->service_center_address)"
                            class="w-full {{ $errors->has('service_center_address') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '' }}"
                            placeholder="Colon St, Cebu City, Cebu" />
                        <x-forms.input-error :messages="$errors->get('service_center_address')" class="mt-2" />
                    </div>
                </div>
            </div>
        </div>

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
