<form method="POST" action="{{ route('store-product') }}" class="space-y-6" enctype="multipart/form-data">
    @csrf
    <div class="bg-white border border-gray-300 rounded-md overflow-hidden">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-300">
            <h1 class="text-neutral-900 text-lg font-semibold">Product Specification</h1>
        </div>
        <div class="px-4 sm:px-6 py-3 sm:py-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                <div class="space-y-1">
                    <x-forms.input-label for="product_name" :hasError="$errors->has('name')" :value="__('Product Name')" />
                    <x-forms.text-input id="product_name" name="name" :value="old('name')"
                        class="w-full {{ $errors->has('name') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '' }}"
                        placeholder="e.g. ROG Zephyrus M16" />
                    <x-forms.input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="space-y-1">
                    <x-forms.input-label for="category" :hasError="$errors->has('category')" :value="__('Category')" />
                    <x-forms.select name="category" :options="$categories" placeholder="Select Category" :selected="request('status')"
                        class="w-full" />
                    <x-forms.input-error :messages="$errors->get('category')" class="mt-2" />
                </div>
                <div class="space-y-1">
                    <x-forms.input-label for="brand" :hasError="$errors->has('brand')" :value="__('Brand')" />
                    <x-forms.text-input id="brand" name="brand" :value="old('brand')"
                        class="w-full {{ $errors->has('brand') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '' }}"
                        placeholder="Enter product manufacturer/brand" />
                    <x-forms.input-error :messages="$errors->get('brand')" class="mt-2" />
                </div>
                <div class="space-y-1">
                    <x-forms.input-label for="warranty_duration" :value="__('Warranty Duration')" />
                    <x-forms.text-input type="number" id="warranty_duration" :value="old('warranty_duration')"
                        name="warranty_duration"
                        class="w-full {{ $errors->has('warranty_duration') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '' }}"
                        placeholder="Enter number of months" />
                    <x-forms.input-error :messages="$errors->get('warranty_duration')" class="mt-2" />
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6">
        <div class="bg-white border border-gray-300 rounded-md overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-300">
                <h1 class="text-neutral-900 text-lg font-semibold">Product Image</h1>
            </div>
            <div class="px-4 sm:px-6 py-4">
                <label class="block mb-2.5 text-sm font-medium text-heading" for="file_input">Upload
                    file</label>
                <input
                    class="{{ $errors->has('product_image_url') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '' }} cursor-pointer bg-neutral-secondary-medium border border-gray-300 text-neutral-500 text-sm rounded-md focus:ring-neutral-900 block w-full shadow-xs placeholder:text-neutral-500"
                    aria-describedby="file_input_help" name="product_image_url" id="file_input" type="file">
                <p class="mt-1 text-sm text-neutral-500" id="file_input_help">SVG, PNG, JPG or GIF</p>
                <x-forms.input-error :messages="$errors->get('product_image_url')" class="mt-2" />
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
                    <x-forms.text-input id="service_center_name" name="service_center_name" :value="old('service_center_name')"
                        class="w-full {{ $errors->has('service_center_name') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '' }}"
                        placeholder="GravStar Service Center Cebu" />
                    <x-forms.input-error :messages="$errors->get('service_center_name')" class="mt-2" />
                </div>
                <div class="space-y-1">
                    <x-forms.input-label for="service_center_address" :hasError="$errors->has('service_center_address')" :value="__('Service Center Name')" />
                    <x-forms.text-input id="service_center_address" name="service_center_address" :value="old('service_center_address')"
                        class="w-full {{ $errors->has('service_center_address') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '' }}"
                        placeholder="Colon St, Cebu City, Cebu" />
                    <x-forms.input-error :messages="$errors->get('service_center_address')" class="mt-2" />
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row justify-end gap-3">
        <x-ui.primary-button class="w-full sm:w-auto justify-center whitespace-nowrap">
            Add Product
        </x-ui.primary-button>
    </div>
</form>
