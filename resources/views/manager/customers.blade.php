<x-admin-layout title="Customers" subtitle="Manage all registered customers and their customer assignments.">
    <div class="bg-white border border-gray-300 rounded-md overflow-hidden">
        <x-ui.manager.table-search route="customers" placeholder="Search Customer name or email" :dropdown="true" />
        <div class="overflow-x-auto">
            @php $headers = ['Customer', 'Email', 'Total Warranties', 'Expired Warranties', 'Last Inquiry']; @endphp
            <x-ui.manager.table :headers="$headers" :action="true" :datas="$customers">
                @forelse ($customers as $customer)
                    <tr>
                        <td class="table-text">
                            <div class="flex items-center space-x-2">
                                <x-icons.avatar :name="$customer->name" size="sm" />
                                <span class="font-semibold">{{ $customer->name }}</span>
                            </div>
                        </td>
                        <td class="table-text">{{ $customer->email }}</td>
                        <td class="table-text">{{ $customer->active_warranties_count }}</td>
                        <td class="table-text">{{ $customer->expired_warranties_count }}</td>
                        <td class="table-text">Replaced</td>
                        <td class="table-text text-right">
                            <button class="text-gray-400 hover:text-gray-600 transition p-2 rounded-full hover:bg-gray-100">
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
                    @php $hasFilters = request()->filled('search') || request()->filled('status'); @endphp
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            @if($hasFilters)
                                <x-ui.is-empty title="No customers found" subTitle="Try adjusting your search or filters" />
                            @else
                                <x-ui.is-empty title="There are no currently customers" subTitle="Register a customers product warranties and send a email inviation link" />
                                <a href="{{ route('register-warranty') }}" class="inline-block mt-6 items-center px-4 py-3 bg-neutral-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black/80 focus:outline-none transition ease-in-out duration-150">
                                    Invite Customers
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforelse
            </x-ui.manager.table>
        </div>
    </div>
</x-admin-layout>
