<x-app-layout>
    <div x-data="{
        activeTab: $persist('records'),
        init() {
            if (!['records', 'inquiry'].includes(this.activeTab)) {
                this.activeTab = 'records'
            }
        }
    }">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="font-semibold text-neutral-900 text-2xl">Warranty Management</h1>
                <p class="text-sm text-neutral-500">Manage your product coverage and support tickets.</p>
            </div>

            <div
                class="inline-flex w-full md:w-auto items-center p-1 space-x-2 bg-white border border-gray-300 rounded-md">
                <button @click="activeTab = 'records'"
                    :class="activeTab === 'records' ? 'bg-neutral-900 text-white' : 'bg-white hover:text-neutral-700'"
                    class="flex-1 font-semibold md:flex-none text-center px-4 py-2 rounded-md">
                    Warranty & History
                </button>
                <button @click="activeTab = 'inquiry'"
                    :class="activeTab === 'inquiry' ? 'bg-neutral-900 text-white' : 'bg-white hover:text-neutral-700'"
                    class="flex-1 font-semibold md:flex-none text-center px-4 py-2 rounded-md">
                    Support Inquiries
                </button>
            </div>
        </div>

        @if (session('success'))
            <x-ui.toast type="success" message="{{ session('success') }}" />
        @endif

        <div x-show="activeTab === 'records'" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2">
            <x-ui.customer.product-details :warranty="$warranty" />

            <h1 class="font-semibold text-neutral-900 text-xl mt-8">Repair and Services History</h1>
            <div class="w-full rounded-md border border-gray-300 overflow-y-auto bg-white mt-2">
                <table class="w-full text-left ">
                    <thead class="bg-white border-b border-gray-300">
                        <tr>
                            <th class="px-6 py-3 text-md font-semibold text-neutral-900">Date</th>
                            <th class="px-6 py-3 text-md font-semibold text-neutral-900">Issue</th>
                            <th class="px-6 py-3 text-md font-semibold text-neutral-900">Action Taken</th>
                            <th class="px-6 py-3 text-md font-semibold text-neutral-900 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-300">
                        @forelse ($history as $his)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                                    {{ $his->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                                    {{ Str::limit($his->message, 15, '...') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                                    @if ($his->resolved_message)
                                        {{ Str::limit($his->resolved_message, 40, '...') }}
                                    @else
                                        The inquiry is currently in review
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-neutral-900">
                                    <x-icons.badge type="{{ $his->status }}" size="sm">
                                        {{ $his->status->label() }}
                                    </x-icons.badge>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <x-ui.is-empty title="Inquiries History"
                                        subTitle="There is no inquiries of this purchase product at the moment" />
                                    <button @click="activeTab = 'inquiry'"
                                        class="mt-2 flex-1 font-semibold md:flex-none bg-neutral-900 text-white text-center px-4 py-2 rounded-md">
                                        Make A Inquiry
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div x-show="activeTab === 'inquiry'" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2">
            <x-ui.customer.discussion :warranty="$warranty" :id="$id" :haveInquiries="$containsInquiries" :messages="$messages" />
        </div>
    </div>
</x-app-layout>
@vite(['resources/js/inquiry/inquiry.js']);