<x-admin-layout title="Product Management" subtitle="Manage your warranty data and configurations.">
    @if (session('success'))
        <x-ui.toast type="success" message="{{ session('success') }}" />
    @endif
    <x-slot:controls>
        <div x-data="{ activePage: $persist('list') }" @set-page.window="activePage = $event.detail"
            class="inline-flex items-center p-1 space-x-1 bg-white border border-gray-300 rounded-md">
            <button @click="$dispatch('set-page', 'list')"
                :class="activePage === 'list' ? 'bg-neutral-900 text-white' : 'bg-white hover:text-neutral-700'"
                class="flex-1 font-semibold md:flex-none text-center px-4 py-2 rounded-md">
                <span>Product List</span>
            </button>
            <button @click="$dispatch('set-page', 'add')"
                :class="activePage === 'add' ? 'bg-neutral-900 text-white' : 'bg-white hover:text-neutral-700'"
                class="flex-1 font-semibold md:flex-none text-center px-4 py-2 rounded-md">
                <span>Add Product</span>
            </button>
        </div>
    </x-slot:controls>
    <div class="mx-auto" x-data="{
        activePage: $persist('add'),
        init() {
            if (!['add', 'list'].includes(this.activePage)) {
                this.activePage = 'add'
            }
        }
    }"@set-page.window="activePage = $event.detail">
        @if (session('status'))
            <x-ui.toast type="success" message="{{ session('status') }}" />
        @endif
        <div x-show="activePage === 'add'" x-cloak>
            <x-ui.manager.store :categories="$categories" />
        </div>
        <div x-show="activePage === 'list'" x-cloak>
            <div class="space-y-4">
                <x-ui.manager.table-search :px="true" route="add-product" statusRoute="add-product" :all="true" placeholder="Search product name, brand or serial number" :select="$categories" />
                <div class="bg-white border border-gray-300 rounded-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <x-ui.manager.list :products="$products" :categories="$categories" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
