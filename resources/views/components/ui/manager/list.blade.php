@props(['products', 'categories'])

<table class="min-w-full divide-y divide-gray-300">
    <thead>
        <tr>
            <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-neutral-900">Product
            </th>
            <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-neutral-900">Category
            </th>
            <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-neutral-900">Brand
            </th>
            <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-neutral-900">Warranty
                Duration</th>
            <th scope="col" class="px-6 py-3 text-right text-sm font-semibold text-neutral-900">Actions
            </th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-300">
        @forelse ($products as $product)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center space-x-2">
                        <div class="h-10 w-10 shrink-0">
                            <img class="h-10 w-10 rounded-md object-cover border border-gray-200"
                                src="{{ $product->image_url }}" alt="Product">
                        </div>
                        <div class="text-sm font-semibold text-gray-900">
                            {{ $product->name }}</div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                    {{ $product->category }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                    {{ $product->brand }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                    {{ $product->warranty_duration }} Months</td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div x-data="{ openActions: false, openEdit: false, openDelete: false, openDetails: false }">
                        <button @click="openActions = !openActions"
                            class="text-gray-400 hover:text-gray-600 transition p-2 rounded-full hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="1"></circle>
                                <circle cx="19" cy="12" r="1"></circle>
                                <circle cx="5" cy="12" r="1"></circle>
                            </svg>
                        </button>
                        <div x-show="openActions" @click.outside="openActions = false"
                            class="bg-white h-auto py-1 w-auto absolute right-18 rounded-md border border-gray-300 flex flex-col all-border items-start z-1000">
                            <button @click="openDetails = !openDetails"
                                class="w-full group flex items-center px-4 py-2 text-sm text-neutral-900 hover:bg-gray-100">
                                <svg class="mr-3 h-4 w-4 text-neutral-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                View
                            </button>
                            <button @click="openEdit = !openEdit"
                                class="w-full group flex items-center px-4 py-2 text-sm text-neutral-900 hover:bg-gray-100">
                                <svg class="mr-3 h-4 w-4 text-neutral-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit
                            </button>
                            <div class="py-1 border-t border-gray-300">
                                <button @click="openDelete = !openDelete"
                                    class="group flex w-full items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <svg class="mr-3 h-4 w-4 text-red-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete
                                </button>
                            </div>
                        </div>

                        {{-- Modals --}}
                        <x-modals.products.view data="openDetails" :product="$product" />
                        <x-modals.products.edit data="openEdit" :categories="$categories" :product="$product" />
                        <x-modals.products.delete data="openDelete" :product="$product" />
                    </div>
            </tr>
        @empty
            <tr>
                @php
                    $hasFilters = request()->filled('search') || request()->filled('category');
                @endphp
                <td colspan="5" class="px-6 py-12 text-center">
                    @if($hasFilters)
                        <x-ui.is-empty title="No products found" subTitle="Try adjusting your search or filter criteria." />
                    @else
                        <x-ui.is-empty title="No products found" subTitle="Start by adding a new product to the system." />
                        <button @click="activePage = 'add'" class="mt-6 inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-neutral-900 rounded-md hover:bg-neutral-800 transition shadow-sm">
                            Add Your First Product
                        </button>
                    @endif
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
