<x-admin-layout>
    <div class="lg:py-6 md:px-6 lg:px-10 max-w-6xl mx-auto w-full space-y-6">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-neutral-900 text-2xl font-bold">Warranty Inquiries</h1>
                <p class="text-neutral-500 text-sm">Review and manage technical support and repair requests from
                    customers.</p>
            </div>
        </div>

        <div class="bg-white border border-gray-300 rounded-md overflow-hidden">
            <div
                class="px-4 py-3 border-b border-gray-300 flex flex-col md:flex-row gap-4 justify-between items-center bg-gray-50/50">
                <div class="relative w-full md:w-96">
                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" placeholder="Search by customer or ticket ID..."
                        class="pl-10 w-full text-sm border-gray-300 rounded-md focus:ring-neutral-900 focus:border-neutral-900">
                </div>

                <div class="flex items-center gap-2 w-full md:w-auto">
                    <select class="text-sm border-gray-300 rounded-md focus:ring-neutral-900">
                        <option value="">All Statuses</option>
                        <option value="open">Open</option>
                        <option value="pending">Pending</option>
                        <option value="in-progress">In-Progress</option>
                        <option value="resolved">Resolved</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-neutral-900">
                                Products
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-neutral-900">
                                Product / Issue
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-neutral-900">
                                Serial Number
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-neutral-900">Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-neutral-900">
                                Submitted
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-sm font-semibold text-neutral-900">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-300">
                        @forelse ($warrantyInquiries as $warrantyInquiry)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                                    <div class="flex items-center space-x-2">
                                        <x-icons.avatar :name="$warrantyInquiry->user->name" size="sm" />
                                        <div>
                                            <p class="font-semibold">{{ $warrantyInquiry->user->name }}</p>
                                            <p class="font-normal text-xs text-neutral-500">
                                                {{ $warrantyInquiry->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                                    <div class="text-sm">
                                        <p class="font-semibold text-neutral-900 text-xs">
                                            {{ $warrantyInquiry->warranty->product->name }}
                                        </p>
                                        <p class="text-neutral-500 truncate max-w-xs">
                                            "{{ Str::limit($warrantyInquiry->message, 15, '...') }}"</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                                    {{ $warrantyInquiry->warranty->serial_number }}
                                </td>
                                <td class="whitespace-nowrap text-sm text-neutral-900">
                                    <x-icons.badge type="{{ $warrantyInquiry->status }}" size="md">
                                        {{ $warrantyInquiry->status->label() }}
                                    </x-icons.badge>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                                    <span title="{{ $warrantyInquiry->created_at->format('F j, Y, g:i a') }}"
                                        class="cursor-pointer">
                                        @if ($warrantyInquiry->created_at->gt(now()->subDays(1)))
                                            {{ $warrantyInquiry->created_at->diffForHumans() }}
                                        @else
                                            {{ $warrantyInquiry->created_at->format('M d, Y') }}
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-neutral-900">
                                    <a href="{{ route('inquiry-action', $warrantyInquiry->id) }}"
                                        class="px-4 py-2 text-white bg-neutral-900 rounded-md font-semibold">Respond</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <x-ui.is-empty title="Warranty Inquiries"
                                        subTitle="There is no warranty inquiries at the moment" />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
