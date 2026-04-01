<x-admin-layout>
    <div class="lg:py-6 md:px-6 lg:px-10 max-w-6xl mx-auto">
        <div class="w-full space-y-6">
            <div class="space-y-3">
                <h1 class="text-neutral-900 text-2xl font-bold">Register New Warranty</h1>
                <p class="text-neutral-500 text-sm">Assign purchase product to the customer and send email invitation</p>
            </div>

            @if (session('status'))
                <x-ui.toast type="success" message="{{ session('status') }}" />
            @endif

            <form method="POST" action="{{ route('register-warranty-details') }}" class="space-y-6">
                @csrf

                {{-- Customer Info --}}
                <div class="bg-white border border-gray-300 rounded-md overflow-hidden">
                    <div class="px-3 sm:px-6 py-4 border-b border-gray-300">
                        <h1 class="text-neutral-900 text-lg font-semibold">Customer Information</h1>
                    </div>

                    <div class="px-4 sm:px-6 py-5">
                        <div class="grid grid-cols-1 max-w-120">
                            <div class="flex-1 space-y-2">
                                <x-forms.input-label for="email" :value="__('Customer Email Address')" />
                                <x-forms.text-input id="email" type="email" name="email" class="w-full"
                                    placeholder="spygod123456@gmail.com" />
                                <x-forms.input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Product Specs --}}
                <div class="bg-white border border-gray-300 rounded-md overflow-hidden">

                    <div class="px-4 sm:px-6 py-4 border-b border-gray-300">
                        <h1 class="text-neutral-900 text-lg font-semibold">Product Specification</h1>
                    </div>

                    <div class="px-4 sm:px-6 py-3 sm:py-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">

                            <div class="space-y-1">
                                <x-forms.input-label for="product_id" :value="__('Product')" />
                                <select id="product_id" name="product_id"
                                    class="w-full border-gray-300 focus:border-neutral-800 focus:ring-neutral-800 rounded-md py-3 px-3 text-sm">
                                    <option value="">Select Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                                <x-forms.input-error :messages="$errors->get('product_id')" class="mt-2" />
                            </div>

                            <div class="space-y-1">
                                <x-forms.input-label for="datepicker-autohide" :value="__('Purchase Date')" />
                                <div class="relative w-full group">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-neutral-500" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z" />
                                        </svg>
                                    </div>

                                    <input id="datepicker-autohide" name="purchase_date" datepicker datepicker-autohide
                                        type="text" datepicker-format="yyyy-mm-dd" placeholder="Select date"
                                        class="block w-full ps-10 pe-3 py-3 bg-white border border-gray-300 text-neutral-900 text-sm rounded-md transition-all focus:outline-none focus:border-neutral-800 focus:ring-1 focus:ring-neutral-800 placeholder:text-neutral-400">
                                    <x-forms.input-error :messages="$errors->get('purchase_date')" class="mt-2" />
                                </div>
                            </div>

                            <div class="space-y-1">
                                <x-forms.input-label for="serial_number" :value="__('Serial Number')" />
                                <x-forms.text-input id="serial_number" name="serial_number" class="w-full"
                                    placeholder="SN-123456789" />
                                <x-forms.input-error :messages="$errors->get('serial_number')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-end gap-3">
                    <x-ui.primary-button class="w-full sm:w-auto justify-center whitespace-nowrap">
                        {{ __('Register and Send Invitation') }}
                    </x-ui.primary-button>
                </div>

            </form>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
</x-admin-layout>
