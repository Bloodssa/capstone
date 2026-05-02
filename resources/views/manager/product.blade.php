<x-admin-layout title="Product Management" subtitle="Manage your warranty data and configurations.">
    @if (session('success'))
        <x-ui.toast type="success" message="{{ session('success') }}" />
    @endif
    @if (session('error'))
        <x-ui.toast type="error" message="{{ session('error') }}" />
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
                <span>Category List</span>
            </button>
        </div>
    </x-slot:controls>
    <div class="mx-auto" x-data="{
        activePage: $persist('list'),
        openStore: @json($errors->product->any()),
        openCategory: @json($errors->category->any()),
        init() {
            if (!['add', 'list'].includes(this.activePage)) {
                this.activePage = 'list';
            }
        }
    }" @set-page.window="activePage = $event.detail">
        @if (session('status'))
            <x-ui.toast type="success" message="{{ session('status') }}" />
        @endif
        <div x-show="activePage === 'add'" x-cloak>

            <div class="mt-4 bg-white border border-gray-300 rounded-md overflow-hidden">
                <div class="px-4 py-3 flex justify-end border-b border-gray-300">
                    <button @click="openCategory = true"
                        class="px-4 py-1.5 bg-neutral-900 text-white font-semibold rounded-md hover:bg-neutral-800 transition">
                        Add Category
                    </button>
                    <x-modals.products.modal data="openCategory">
                        <div class="mb-8">
                            <h4 class="text-[24px] font-semibold text-gray-800">Add Category</h4>
                            <p class="text-sm text-gray-500">Create a new category.</p>
                        </div>
                        <form method="POST" action="{{ route('store-category') }}" class="space-y-6">
                            @csrf
                            <div class="space-y-1">
                                <x-forms.input-label for="category_name" :hasError="$errors->has('name')" value="Category Name" />
                                <x-forms.text-input id="category_name" name="name" :value="old('name', null)"
                                    class="w-full {{ $errors->has('name') ? 'border-red-500' : '' }}"
                                    placeholder="e.g. Laptop" />
                                <x-forms.input-error :messages="$errors->category->get('name')" class="mt-2" />
                            </div>
                            <div class="flex flex-col sm:flex-row justify-end gap-3 mt-6">
                                <button type="button" @click="openCategory = false"
                                    class="px-6 py-2 border border-gray-300 rounded-md text-neutral-900 hover:bg-gray-50">
                                    Cancel
                                </button>
                                <x-ui.primary-button class="w-full sm:w-auto justify-center whitespace-nowrap">
                                    Add Category
                                </x-ui.primary-button>
                            </div>
                        </form>
                    </x-modals.products.modal>
                </div>
                <div class="overflow-x-auto">
                    @php $headers = ['Category Name']; @endphp
                    <x-ui.manager.table :borderTop="false" :headers="$headers" :action="true" :datas="$categories">
                        @forelse ($categories as $category)
                            <tr>
                                <td class="table-text font-semibold">{{ $category->name }}</td>
                                <td class="table-text text-right">
                                    <div x-data="{ openActions: false, openEdit: false, openDelete: false }">
                                        <button @click="openActions = !openActions"
                                            class="text-gray-400 hover:text-gray-600 transition p-2 rounded-full hover:bg-gray-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="19" cy="12" r="1"></circle>
                                                <circle cx="5" cy="12" r="1"></circle>
                                            </svg>
                                        </button>
                                        <div x-show="openActions" @click.outside="openActions = false" x-transition
                                            class="absolute right-15 mt-2 w-40 bg-white border border-gray-300 rounded-md shadow-lg z-50">
                                            <button @click="openEdit = true; openActions = false"
                                                class="w-full flex items-center px-4 py-2 text-sm text-neutral-900 hover:bg-gray-100">
                                                <svg class="mr-3 h-4 w-4 text-neutral-500" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Edit
                                            </button>
                                            <button @click="openDelete = true; openActions = false"
                                                class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 border-t border-gray-200">
                                                <svg class="mr-3 h-4 w-4 text-red-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Delete
                                            </button>
                                        </div>
                                        <x-modals.products.modal data="openEdit">
                                            <div class="mb-6">
                                                <h4 class="text-[24px] font-semibold text-gray-800">Edit Category</h4>
                                                <p class="text-sm text-gray-500">Update category name.</p>
                                            </div>
                                            <form method="POST" action="{{ route('update-category', $category->id) }}"
                                                class="space-y-6">
                                                @csrf
                                                @method('PUT')
                                                <div class="space-y-1">
                                                    <x-forms.input-label for="category_name_{{ $category->id }}"
                                                        value="Category Name" />
                                                    <x-forms.text-input id="category_name_{{ $category->id }}"
                                                        name="name" :value="old('name', $category->name)" class="w-full"
                                                        placeholder="e.g. Laptop" />
                                                    <x-forms.input-error :messages="$errors->get('name')" class="mt-2" />
                                                </div>
                                                <div class="flex justify-end gap-3">
                                                    <button type="button" @click="openEdit = false"
                                                        class="px-6 py-2 border border-gray-300 rounded-md text-neutral-900 hover:bg-gray-50">
                                                        Cancel
                                                    </button>
                                                    <x-ui.primary-button>
                                                        Update
                                                    </x-ui.primary-button>
                                                </div>
                                            </form>
                                        </x-modals.products.modal>
                                        <x-modals.products.delete data="openDelete" title="Delete Category" :name="$category->name" :route="route('delete-category', $category->id)" />
                                    </div>
                                </td>
                            </tr>
                        @empty
                            @php $hasFilters = request()->filled('search') || request()->filled('status'); @endphp
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    @if ($hasFilters)
                                        <x-ui.is-empty title="No customers found"
                                            subTitle="Try adjusting your search or filters" />
                                    @else
                                        <x-ui.is-empty title="There are no currently customers"
                                            subTitle="Register a customers product warranties and send a email inviation link" />
                                        <a href="{{ route('register-warranty') }}"
                                            class="inline-block mt-6 items-center px-4 py-3 bg-neutral-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black/80 focus:outline-none transition ease-in-out duration-150">
                                            Invite Customers
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </x-ui.manager.table>
                </div>
            </div>
        </div>
        <div x-show="activePage === 'list'" x-cloak>
            <div class="space-y-4">
                <div class="bg-white border border-gray-300 rounded-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <x-ui.manager.list :products="$products" :categoriesFilter="$categoriesForFilter" :categoriesForm="$categoriesForForm" />
                    </div>
                </div>
                <x-modals.products.modal data="openStore">
                    <div class="mb-8">
                        <h4 class="text-[24px] font-semibold text-gray-800">Add Product</h4>
                        <p class="text-sm text-gray-500">Create a new product entry in the system.</p>
                    </div>
                    <form method="POST" action="{{ route('store-product') }}" class="space-y-6"
                        enctype="multipart/form-data">
                        @csrf
                        <x-modals.products.product-form :categories="$categoriesForForm" />
                        <div class="flex flex-col sm:flex-row justify-end gap-3 mt-6">
                            <button type="button" @click="openStore = false"
                                class="px-6 py-2 border border-gray-300 rounded-md text-neutral-900 hover:bg-gray-50">
                                Cancel
                            </button>
                            <x-ui.primary-button class="w-full sm:w-auto justify-center whitespace-nowrap">
                                Add Product
                            </x-ui.primary-button>
                        </div>
                    </form>
                </x-modals.products.modal>
            </div>
        </div>
    </div>
</x-admin-layout>
