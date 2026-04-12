<x-admin-layout title="Warranty Inquiries"
    subtitle="Review and manage technical support and repair requests from customers.">
    <div class="mt-6 bg-white border border-gray-300 rounded-md overflow-hidden">
        <x-ui.manager.table-search route="warranty-inquiries" placeholder="Search product name, customer, serial number"
            statusRoute="warranty-inquiries" name="status" :select="$select" />
        <div class="overflow-x-auto">
            @php
                $headers = ['Customer', 'Product / Issue', 'Serial Number', 'Status', 'Submitted'];
            @endphp
            <x-ui.manager.table :headers="$headers" :action="true" :datas="$warrantyInquiries">
                @forelse ($warrantyInquiries as $data)
                    <tr>
                        <td class="table-text">
                            <div class="flex items-center space-x-2">
                                <x-icons.avatar :name="$data->user->name" size="sm" />
                                <div>
                                    <p class="font-semibold">{{ $data->user->name }}</p>
                                    <p class="font-normal text-xs text-neutral-500">
                                        {{ $data->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="table-text">
                            <div class="text-sm">
                                <p class="font-semibold text-neutral-900 text-xs">
                                    {{ $data->warranty->product->name }}
                                </p>
                                <p class="text-neutral-500 truncate max-w-xs">
                                    "{{ Str::limit($data->message, 15, '...') }}"</p>
                            </div>
                        </td>
                        <td class="table-text">
                            {{ $data->warranty->serial_number }}
                        </td>
                        <td class="whitespace-nowrap text-sm text-neutral-900">
                            <x-icons.badge type="{{ $data->status }}" size="md">
                                {{ $data->status->label() }}
                            </x-icons.badge>
                        </td>
                        <td class="table-text">
                            <span title="{{ $data->created_at->format('F j, Y, g:i a') }}" class="cursor-pointer">
                                @if ($data->created_at->gt(now()->subDays(1)))
                                    {{ $data->created_at->diffForHumans() }}
                                @else
                                    {{ $data->created_at->format('M d, Y') }}
                                @endif
                            </span>
                        </td>
                        <td class="table-text text-right">
                            <a href="{{ route('inquiry-action', $data->id) }}"
                                class="px-4 py-2 text-white bg-neutral-900 rounded-md font-semibold">Respond</a>
                        </td>
                    </tr>
                @empty
                    @php
                        $hasFilters = request()->filled('search') || request()->filled('status');
                    @endphp
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            @if ($hasFilters)
                                <x-ui.is-empty title="No inquiries found" subTitle="Try adjusting your search or filters" />
                            @else
                                <x-ui.is-empty title="No warranty inquiries yet" subTitle="Customer inquiries about warranties will appear here" />
                            @endif
                        </td>
                    </tr>
                @endforelse
            </x-ui.manager.table>
        </div>
    </div>
</x-admin-layout>
