<x-admin-layout>
    <div class="mt-6 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <x-ui.summary color="emerald" :count="$activeWarrantyCount" title="Active Warranties" :url="route('active-warranties')"
                icon="M200-200v-560 454-85 191Zm0 80q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v320h-80v-320H200v560h280v80H200Zm494 40L552-222l57-56 85 85 170-170 56 57L694-80ZM348.5-451.5Q360-463 360-480t-11.5-28.5Q337-520 320-520t-28.5 11.5Q280-497 280-480t11.5 28.5Q303-440 320-440t28.5-11.5Zm0-160Q360-623 360-640t-11.5-28.5Q337-680 320-680t-28.5 11.5Q280-657 280-640t11.5 28.5Q303-600 320-600t28.5-11.5ZM440-440h240v-80H440v80Zm0-160h240v-80H440v80Z" />
            <x-ui.summary color="amber" :count="$repairInquires" title="Open Repair Inquiries" :url="route('warranty-inquiries')"
                icon="M280-720v-40q0-33 23.5-56.5T360-840h240q33 0 56.5 23.5T680-760v40h28q24 0 43.5 13.5T780-672l94 216q3 8 4.5 16t1.5 16v184q0 33-23.5 56.5T800-160H160q-33 0-56.5-23.5T80-240v-184q0-8 1.5-16t4.5-16l94-216q9-21 28.5-34.5T252-720h28Zm80 0h240v-40H360v40Zm-80 240v-40h80v40h240v-40h80v40h96l-68-160H252l-68 160h96Zm0 80H160v160h640v-160H680v40h-80v-40H360v40h-80v-40Zm200-40Zm0-40Zm0 80Z" />
            <x-ui.summary color="amber" title="Unread Messages" :url="route('warranty')"
                icon="M593-567q47-47 47-113v-120H320v120q0 66 47 113t113 47q66 0 113-47ZM160-80v-80h80v-120q0-61 28.5-114.5T348-480q-51-32-79.5-85.5T240-680v-120h-80v-80h640v80h-80v120q0 61-28.5 114.5T612-480q51 32 79.5 85.5T720-280v120h80v80H160Z" />
            <x-ui.summary color="amber" :count="$customerCount" title="Total Customers" :url="route('customers')"
                icon="M555-435q-35-35-35-85t35-85q35-35 85-35t85 35q35 35 35 85t-35 85q-35 35-85 35t-85-35ZM400-160v-76q0-21 10-40t28-30q45-27 95.5-40.5T640-360q56 0 106.5 13.5T842-306q18 11 28 30t10 40v76H400Zm86-80h308q-35-20-74-30t-80-10q-41 0-80 10t-74 30Zm182.5-251.5Q680-503 680-520t-11.5-28.5Q657-560 640-560t-28.5 11.5Q600-537 600-520t11.5 28.5Q623-480 640-480t28.5-11.5ZM640-520Zm0 280ZM120-400v-80h320v80H120Zm0-320v-80h480v80H120Zm324 160H120v-80h360q-14 17-22.5 37T444-560Z" />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 grow overflow-hidden rounded-md border border-gray-300 bg-white p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">
                        Warranty Status
                    </h3>
                </div>
                <div class="max-w-full overflow-x-auto custom-scrollbar">
                    <div class="min-w-125 xl:min-w-full">
                        {{-- Chart Element --}}
                        <div id="warranty-status-chart" data-categories='@json($chartMonths)'
                            data-active='@json($chartActive)' data-near-expiry='@json($chartNearExpiry)'
                            data-expired='@json($chartExpired)' class="h-87.5 w-full"></div>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-300 rounded-md">
                <div class="px-5 py-4 border-b border-gray-300">
                    <h1 class="text-neutral-900 font-semibold text-base">
                        Most Reported Products
                    </h1>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse ($mostReportedProducts as $reportedProducts)
                        <div class="p-4 flex items-center justify-between">
                            <div class="flex items-center gap-3 w-full min-w-0">
                                <div class="w-12 h-12 border border-gray-300 rounded-md overflow-hidden shrink-0">
                                    <img src="{{ asset('storage/' . $reportedProducts->product_image_url) }}"
                                        alt="{{ $reportedProducts->name }}" class="w-full h-full object-cover" />
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-neutral-900 text-base font-semibold leading-tight truncate">
                                        {{ $reportedProducts->name }}
                                    </h3>
                                    <p class="text-neutral-500 text-xs mt-0.5">
                                        {{ $reportedProducts->category_name }}
                                    </p>
                                </div>
                            </div>
                            <div class="pl-6 flex flex-col items-end justify-center text-right">
                                <span class="text-neutral-500 text-[13px] font-semibold">
                                    Reports
                                </span>
                                <span class="text-neutral-900 font-bold text-sm tabular-nums">
                                    {{ $reportedProducts->total_inquiries }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="w-full py-6 px-3 lg:py-20 flex items-center justify-center">
                            <x-ui.is-empty title="Reported Products"
                                subTitle="There is no most reported products at the moment" />
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white border border-gray-300 rounded-md overflow-hidden">
                <div class="px-5 py-4">
                    <h1 class="text-neutral-900 font-semibold text-base">
                        Latest Warranty Inquiries
                    </h1>
                </div>
                <div class="overflow-x-auto">
                    @php
                        $headers = ['Customer', 'Product', 'Status'];
                    @endphp
                    <x-ui.manager.table :headers="$headers" :datas="$latestInquiries">
                        @forelse ($latestInquiries as $latestInquiry)
                            <tr>
                                <td class="table-text">
                                    <div class="flex items-center space-x-2">
                                        <x-icons.avatar :name="$latestInquiry->user->name" size="sm" />
                                        <span class="font-semibold">{{ $latestInquiry->user->name }}</span>
                                    </div>
                                </td>
                                <td class="table-text">
                                    {{ $latestInquiry->warranty->product->name }}
                                </td>
                                <td class="table-text">
                                    {{ $latestInquiry->status->label() }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center">
                                    <x-ui.is-empty title="Latest warranty inquiries"
                                        subTitle="There is no latest inquiries at the moment" />
                                </td>
                            </tr>
                        @endforelse
                    </x-ui.manager.table>
                </div>
            </div>
            <div class="bg-white border border-gray-300 rounded-md overflow-hidden">
                <div class="px-5 py-4">
                    <h1 class="text-neutral-900 font-semibold text-base">
                        Pending Inquiry Requests
                    </h1>
                </div>
                <div class="overflow-x-auto">
                    @php
                        $headers = ['Customer', 'Product', 'Inquire Date'];
                    @endphp
                    <x-ui.manager.table :headers="$headers" :datas="$pendingInquiries">
                        @forelse ($pendingInquiries as $pendingInquiry)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                                    <div class="flex items-center space-x-2">
                                        <x-icons.avatar :name="$pendingInquiry->user->name" size="sm" />
                                        <span class="font-semibold">{{ $pendingInquiry->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                                    {{ $pendingInquiry->warranty->product->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                                    {{ $pendingInquiry->created_at->format('M d, Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center">
                                    <x-ui.is-empty title="Pending warranty inquiries"
                                        subTitle="There is no pending inquiries at the moment" />
                                </td>
                            </tr>
                        @endforelse
                    </x-ui.manager.table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
@vite(['resources/js/charts.js'])
