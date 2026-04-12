<x-admin-layout title="Warranty Report" subtitle="System analytics and reliability logs.">
    <x-slot:controls>
        <div class="flex items-center space-x-3">
            <form action="{{ route('reports') }}" method="GET" id="filterForm">
                @php
                    $periods = ['7' => 'Last 7 Days', '30' => 'Last 30 Days', '12' => 'Last 12 Months'];
                @endphp
                <x-forms.select name="period" :options="$periods" :selected="$selectedPeriod" onchange="this.form.submit()"
                    class="font-semibold text-neutral-900" />
            </form>
            <a href="{{ route('generate', ['period' => $selectedPeriod]) }}"
                class="inline-flex items-center bg-neutral-900 text-white text-sm font-semibold px-4 py-2 rounded-md hover:bg-neutral-800 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download PDF
            </a>
        </div>
    </x-slot:controls>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-ui.summary color="emerald" :count="$activeWarranty" title="Active Warranties" :url="route('warranty')"
            icon="M438-226 296-368l58-58 84 84 168-168 58 58-226 226ZM200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Z" />
        <x-ui.summary color="amber" :count="$warrantyClaimCount" title="Total Warranty Claims" :url="route('warranty')"
            icon="M593-567q47-47 47-113v-120H320v120q0 66 47 113t113 47q66 0 113-47ZM160-80v-80h80v-120q0-61 28.5-114.5T348-480q-51-32-79.5-85.5T240-680v-120h-80v-80h640v80h-80v120q0 61-28.5 114.5T612-480q51 32 79.5 85.5T720-280v120h80v80H160Z" />
        <x-ui.summary color="blue" :count="$resolvedInquiry" title="Resolved Inquiries" :url="route('warranty')"
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
                <div id="chartOne" data-count='@json($chartsData->inquiries->data)' data-months='@json($chartsData->inquiries->labels)'
                    class="h-96 w-full">
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
        <div class="px-5 py-4">
            <h1 class="text-neutral-900 font-semibold text-base">
                Warranty Near-Expiry
            </h1>
        </div>
        @php
            $headers = ['Product', 'Customer', 'Expiry Date'];
        @endphp
        <x-ui.manager.table :headers="$headers" :datas="$nearExpiryWarranties">
            @forelse ($nearExpiryWarranties as $nearExpiryWarranty)
                <tr>
                    <td class="table-text">
                        {{ $nearExpiryWarranty->product->name }}</td>
                    <td class="table-text">
                        <div class="flex items-center space-x-2">
                            <x-icons.avatar :name="$nearExpiryWarranty->user->name" size="sm" />
                            <span class="font-semibold">{{ $nearExpiryWarranty->user->name }}</span>
                        </div>
                    </td>
                    <td class="table-text">
                        {{ (int) now()->diffInDays($nearExpiryWarranty->expiry_date) }} days left</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <x-ui.is-empty title="Customer warranties"
                            subTitle="There is no warranty near-expiry at the moment" />
                    </td>
                </tr>
            @endforelse
        </x-ui.manager.table>
    </div>
</x-admin-layout>   
@vite(['resources/js/charts.js'])
