@props(['product' => null, 'categories' => []])
@php
    $isEdit = $product !== null;
    $idSuffix = $isEdit ? $product->id : 'new';
    $initialImageUrl = $isEdit && $product->product_image_url ? asset('storage/' . $product->product_image_url) : null;
@endphp

<div class="space-y-6">
    <div class="bg-white border border-gray-300 rounded-md overflow-hidden">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-300">
            <h1 class="text-neutral-900 text-lg font-semibold">Product Specification</h1>
        </div>
        <div class="px-4 sm:px-6 py-3 sm:py-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                <div class="space-y-1">
                    <x-forms.input-label for="product_name" :hasError="$errors->has('name')" :value="__('Product Name')" />
                    <x-forms.text-input id="product_name" name="name" :value="old('name', $product->name ?? '')"
                        class="w-full {{ $errors->has('name') ? 'border-red-500' : '' }}"
                        placeholder="e.g. ROG Zephyrus M16" />
                    <x-forms.input-error :messages="$errors->product->get('name')" class="mt-2" />
                </div>
                <div class="space-y-1">
                    <x-forms.input-label for="category_id" :hasError="$errors->has('category_id')" :value="__('Category')" />
                    <x-forms.select name="category_id" :options="$categories" placeholder="Select Category" :selected="old('category_id', $product->category_id ?? '')"
                        class="w-full" />
                    <x-forms.input-error :messages="$errors->product->get('category_id')" class="mt-2" />
                </div>
                <div class="space-y-1">
                    <x-forms.input-label for="brand" :hasError="$errors->has('brand')" :value="__('Brand')" />
                    <x-forms.text-input id="brand" name="brand" :value="old('brand', $product->brand ?? '')"
                        class="w-full {{ $errors->has('brand') ? 'border-red-500' : '' }}"
                        placeholder="Enter product brand" />
                    <x-forms.input-error :messages="$errors->product->get('brand')" class="mt-2" />
                </div>
                <div class="space-y-1">
                    <x-forms.input-label for="warranty_duration" :value="__('Warranty Duration')" />
                    <x-forms.text-input type="number" id="warranty_duration" :value="old('warranty_duration', $product->warranty_duration ?? '')"
                        name="warranty_duration"
                        class="w-full {{ $errors->has('warranty_duration') ? 'border-red-500' : '' }}"
                        placeholder="Enter number of months" />
                    <x-forms.input-error :messages="$errors->product->get('warranty_duration')" class="mt-2" />
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white border border-gray-300 rounded-md overflow-hidden" x-data="{
        imageUrl: '{{ $initialImageUrl }}',
        imageUpdate(event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                this.imageUrl = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-300">
            <h1 class="text-neutral-900 text-lg font-semibold">Product Image</h1>
        </div>
        <div class="p-4 sm:p-6">
            <div x-show="imageUrl" class="mb-6">
                <div class="relative group border border-gray-300 rounded-md overflow-hidden max-w-lg mx-auto bg-gray-50">
                    <img :src="imageUrl" class="w-full h-64 object-contain">
                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <label for="product_image_input_{{ $idSuffix }}" class="cursor-pointer py-3 px-6 bg-neutral-900 hover:bg-neutral-800 text-white font-semibold rounded-md">
                            Update Image
                        </label>
                    </div>
                </div>
            </div>
            <div x-show="!imageUrl"
                class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-lg py-12 bg-gray-50 hover:bg-gray-100 transition-colors">
                <label for="product_image_input_{{ $idSuffix }}" class="cursor-pointer flex flex-col items-center">
                    <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="text-sm font-medium text-gray-700">Click to upload product image</span>
                    <span class="text-xs text-gray-500 mt-1">PNG, JPG, SVG or GIF</span>
                </label>
            </div>
            <input type="file" name="product_image_url" id="product_image_input_{{ $idSuffix }}" accept="image/*" @change="imageUpdate" class="hidden" />
            <x-forms.input-error :messages="$errors->product->get('product_image_url')" class="mt-4" />
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
                    <x-forms.text-input id="service_center_name" name="service_center_name" :value="old('service_center_name', $product->service_center_name ?? '')"
                        class="w-full {{ $errors->has('service_center_name') ? 'border-red-500' : '' }}"
                        placeholder="Service Center Name" />
                    <x-forms.input-error :messages="$errors->product->get('service_center_name')" class="mt-2" />
                </div>
                <div class="space-y-1">
                    <x-forms.input-label for="service_center_address" :hasError="$errors->has('service_center_address')" :value="__('Service Center Address')" />
                    <x-forms.text-input id="service_center_address" name="service_center_address" :value="old('service_center_address', $product->service_center_address ?? '')"
                        class="w-full {{ $errors->has('service_center_address') ? 'border-red-500' : '' }}"
                        placeholder="Service Center Address" />
                    <x-forms.input-error :messages="$errors->product->get('service_center_address')" class="mt-2" />
                </div>
            </div>
        </div>
    </div>
</div>
