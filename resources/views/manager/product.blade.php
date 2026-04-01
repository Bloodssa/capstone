<x-admin-layout>

    @if (session('productAdded'))
        <x-ui.toast type="success" message="{{ session('productAdded') }}" />
    @endif

    <div class="lg:py-6 md:px-6 lg:px-10 max-w-6xl mx-auto" x-data="{
        activePage: $persist('add'),
        init() {
            if (!['add', 'list'].includes(this.activePage)) {
                this.activePage = 'add'
            }
        }
    }">
        <div class="w-full space-y-6">
            <div
                class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between pb-4 mb-6">
                <div>
                    <h1 class="text-neutral-900 text-2xl font-bold">Product Management</h1>
                    <p class="text-neutral-500 text-sm">Manage your warranty data and configurations.</p>
                </div>

                <div
                    class="inline-flex w-full md:w-auto items-center p-1 space-x-2 bg-white border border-gray-300 rounded-md">

                    <button @click="activePage = 'list'"
                        :class="activePage === 'list' ? 'bg-neutral-900 text-white' : 'bg-white hover:text-neutral-700'"
                        class="flex-1 font-semibold md:flex-none text-center px-4 py-2 rounded-md">
                        <span>Product List</span>
                    </button>

                    <button @click="activePage = 'add'"
                        :class="activePage === 'add' ? 'bg-neutral-900 text-white' : 'bg-white hover:text-neutral-700'"
                        class="flex-1 font-semibold md:flex-none text-center px-4 py-2 rounded-md">
                        <span>Add Product</span>
                    </button>
                </div>
            </div>

            @if (session('status'))
                <x-ui.toast type="success" message="{{ session('status') }}" />
            @endif

            {{-- ADD PAGE --}}
            <div x-show="activePage === 'add'" x-cloak>
                <x-ui.manager.store />
            </div>

            {{-- LIST PAGE --}}
            <div x-show="activePage === 'list'" x-cloak>
                <div class="space-y-4">
                    <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                        <div class="relative w-full md:w-96">
                            <div class="relative flex-1 group">
                                <div
                                    class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-gray-600 z-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-neutral-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <x-forms.text-input type="text" :icon="true"
                                    placeholder="Search products or serial numbers..." />
                            </div>
                        </div>
                        <div class="flex items-center gap-2 w-full md:w-auto">
                            <x-forms.dropdown />
                        </div>
                    </div>

                    <div class="bg-white border border-gray-300 rounded-md overflow-hidden">
                        <div class="overflow-x-auto">
                        <x-ui.manager.list :products="$products" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
