<x-admin-layout>
    <div class="lg:py-6 md:px-6 lg:px-10 max-w-6xl mx-auto w-full space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-neutral-900">Warranty Report</h1>
                <p class="text-sm text-neutral-500">System analytics and reliability logs.</p>
            </div>
            <div class="flex items-center space-x-3">
                <form action="{{ route('reports') }}" method="GET" id="filterForm">
                    <select name="period" onchange="this.form.submit()"
                        class="rounded-md border-gray-300 text-sm font-semibold text-neutral-900 focus:ring-neutral-900 focus:border-neutral-900">
                        <option value="7" @selected($selectedPeriod == '7')>Last 7 Days</option>
                        <option value="30" @selected($selectedPeriod == '30')>Last 30 Days</option>
                        <option value="12" @selected($selectedPeriod == '12')>Last 12 Months</option>
                    </select>   
                </form>

                <a href="#"
                    class="inline-flex items-center bg-neutral-900 text-white text-sm font-semibold px-4 py-2 rounded-md hover:bg-neutral-800 transition">
                    Download PDF
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-ui.customer.summary color="emerald" :count="$activeWarranty" title="Active Warranties" :url="route('warranty')"
                icon="M438-226 296-368l58-58 84 84 168-168 58 58-226 226ZM200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Z" />
            <x-ui.customer.summary color="amber" :count="$warrantyClaimCount" title="Total Warranty Claims" :url="route('warranty')"
                icon="M593-567q47-47 47-113v-120H320v120q0 66 47 113t113 47q66 0 113-47ZM160-80v-80h80v-120q0-61 28.5-114.5T348-480q-51-32-79.5-85.5T240-680v-120h-80v-80h640v80h-80v120q0 61-28.5 114.5T612-480q51 32 79.5 85.5T720-280v120h80v80H160Z" />
            <x-ui.customer.summary color="blue" :count="$resolvedInquiry" title="Resolved Inquiries" :url="route('warranty')"
                icon="M480-400ZM80-160v-400q0-33 23.5-56.5T160-640h120v-80q0-33 23.5-56.5T360-800h240q33 0 56.5 23.5T680-720v80h120q33 0 56.5 23.5T880-560v400H80Zm240-200v40h-80v-40h-80v120h640v-120h-80v40h-80v-40H320ZM160-560v120h80v-40h80v40h320v-40h80v40h80v-120H160Zm200-80h240v-80H360v80Z" />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
            <div class="lg:col-span-3 overflow-hidden rounded-md border border-gray-300 bg-white p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">
                        Warranty Inquiries
                    </h3>
                </div>

                <div class="w-full">
                    <div id="chartOne" data-count='@json($chartsData->inquiries->data)'
                        data-months='@json($chartsData->inquiries->labels)' class="h-96 w-full">
                    </div>
                </div>
            </div>
            <div class="lg:col-span-2 bg-white border border-gray-300 rounded-md p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">
                        Most Reported Products
                    </h3>
                </div>

                <div class="w-full">
                    <div id="top-reported-products" data-report-count='@json($chartsData->reportedProducts->data)'
                        data-reported-name='@json($chartsData->reportedProducts->labels)' class="h-96 w-full">
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-300 rounded-md overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-300">
                <h1 class="text-neutral-900 font-semibold text-base">
                    Warranty Near-Expiry
                </h1>
            </div>

            <table class="min-w-full divide-y divide-gray-300">
                <thead>
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-neutral-900">
                            Product
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-neutral-900">
                            Customer
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-sm font-semibold text-neutral-900">
                            Expiry Date
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-300">
                    @forelse ($nearExpiryWarranties as $nearExpiryWarranty)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                                {{ $nearExpiryWarranty->product->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                                <div class="flex items-center space-x-2">
                                    <x-icons.avatar :name="$nearExpiryWarranty->user->name" size="sm" />
                                    <span class="font-semibold">{{ $nearExpiryWarranty->user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-neutral-900">
                                {{ (int) now()->diffInDays($nearExpiryWarranty->expiry_date) }} days left</td>
                        </tr>
                    @empty
                        <h1>Nothing</h1>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-admin-layout>

@vite(['resources/js/charts.js'])
