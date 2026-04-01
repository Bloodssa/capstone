<x-admin-layout>
    <div class="lg:py-6 md:px-6 lg:px-10 max-w-6xl mx-auto w-full space-y-6">

        <div class="space-y-2">
            <h1 class="text-neutral-900 text-2xl font-bold">Customers</h1>
            <p class="text-neutral-500 text-sm">
                Manage all registered customers and their customer assignments.
            </p>
        </div>

        <div class="bg-white border border-gray-300 rounded-md overflow-hidden">

            <div class="overflow-x-auto">
                <div class="w-full px-4  py-2 flex justify-end border-b border-gray-300">
                    <div class="relative w-full md:w-96 max-h-10">
                        <div class="relative flex-1 group">
                            <div
                                class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-gray-600 z-10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-neutral-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <x-forms.text-input type="text" :icon="true" class="h-9"
                                placeholder="Search products or serial numbers..." />
                        </div>
                    </div>
                </div>
                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-neutral-900">
                                Customer
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-neutral-900">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-neutral-900">Total
                                Warranties
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-neutral-900">
                                Expired Warranties
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-neutral-900">
                                Last Inquiry
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-sm font-semibold text-neutral-900">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-300">
                        @forelse ($customers as $customer)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                                    <div class="flex items-center space-x-2">
                                        <x-icons.avatar :name="$customer->name" size="sm" />
                                        <span class="font-semibold">{{ $customer->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                                    {{ $customer->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                                    {{ $customer->active_warranties_count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                                    {{ $customer->expired_warranties_count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                                    Replaced</td>
                                <td class="px-6 text-right py-4 whitespace-nowrap text-sm text-neutral-900">
                                    <button
                                        class="text-gray-400 hover:text-gray-600 transition p-2 rounded-full hover:bg-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="1"></circle>
                                            <circle cx="19" cy="12" r="1"></circle>
                                            <circle cx="5" cy="12" r="1"></circle>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <x-ui.is-empty title="There are no currently customers"
                                        subTitle="Register a customers product warranties and send a email inviation link" />
                                    <a href="{{ route('register-warranty') }}"
                                        class="inline-block mt-6 items-center px-4 py-3 bg-neutral-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black/80 focus:outline-none transition ease-in-out duration-150">
                                        Invite Customers
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if ($customers->hasPages())
                    <div class="px-3 py-2 w-full border-t border-gray-300">
                        {{ $customers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
