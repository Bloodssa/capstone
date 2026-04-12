<x-admin-layout :header="false">
    @if (session('status'))
        <x-ui.toast type="success" message="{{ session('status') }}" />
    @endif
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-neutral-900 text-2xl font-bold">Inquiry Details</h1>
            </div>
            <a href="{{ route('warranty-inquiries') }}"
                class="text-sm font-semibold text-neutral-600 hover:text-neutral-900 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Inquiries
            </a>
        </div>
        <x-ui.progress :inquiryStatus="$inquiry->status->value" />
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="lg:col-span-2 flex flex-col bg-white border border-gray-300 rounded-md h-170 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-300">
                    <div class="flex items-center space-x-2">
                        <x-icons.avatar :name="$inquiry->user->name" size="sm" />
                        <div>
                            <p class="font-semibold">{{ $inquiry->user->name }}</p>
                            <p class="font-normal text-xs text-neutral-500">
                                {{ $inquiry->user->email }}</p>
                        </div>
                    </div>
                </div>
                <x-ui.chat-box :messages="$messages" />
                <x-forms.reply :action="route('inquiry-response')" buttonText="Response"
                    placeholder="Response to the inquiry of the user">
                    <x-slot name="hiddenInputs">
                        <input type="hidden" name="warranty_inquiries_id" value="{{ $inquiry->id }}">
                    </x-slot>
                </x-forms.reply>
            </div>
            <div class="space-y-4">
                <div class="bg-white border border-gray-300 rounded-md">
                    <div class="px-5 py-4 border-b border-gray-300">
                        <h1 class="text-neutral-900 font-semibold text-base">
                            Update Progress
                        </h1>
                    </div>
                    <form action="{{ route('inquiry-status', $inquiry->id) }}" method="POST" class="space-y-4 p-5">
                        @csrf
                        @method('PATCH')
                        @php
                            $status = $inquiry->status?->value;
                        @endphp
                        <select name="status" data-current="{{ $inquiry->status }}"
                            class="w-full border-gray-300 rounded-md text-sm focus:ring-neutral-900 focus:border-neutral-900">
                            <option value="pending" @selected($status == 'pending')>Pending</option>
                            <option value="in-progress" @selected($status == 'in-progress')>In-Progress</option>
                            <option value="resolved" @selected($status == 'resolved')>Resolved</option>
                            <option value="replaced" @selected($status == 'replaced')>Replaced</option>
                            <option value="closed" @selected($status == 'closed')>Closed</option>
                        </select>
                        <button type="submit"
                            class="w-full bg-neutral-900 text-white py-3 rounded-md text-sm font-semibold hover:bg-neutral-800 transition">
                            Apply Status Change
                        </button>
                    </form>
                </div>
                <div class="bg-white border border-gray-300 rounded-md space-y-3">
                    <div class="px-5 py-4 border-b border-gray-300">
                        <h1 class="text-neutral-900 font-semibold text-base">
                            Warranty Details
                        </h1>
                    </div>
                    <div class="flex items-center gap-4 px-5">
                        <div class="shrink-0">
                            <img class="h-16 w-16 object-contain border border-gray-300 rounded bg-white"
                                src="{{ asset('storage/' . $inquiry->warranty->product->product_image_url) }}"
                                alt="{{ $inquiry->warranty->product->name }}" />
                        </div>
                        <div class="min-w-0">
                            <span class="text-sm text-neutral-500">Product Name</span>
                            <p class="text-md font-bold text-neutral-900">
                                {{ $inquiry->warranty->product->name }}
                            </p>
                            <p class="text-sm text-neutral-500">{{ $inquiry->warranty->product->category }}</p>
                        </div>
                    </div>
                    <div class="border-t border-gray-300 px-5">
                        <div>
                            <span class="text-sm text-neutral-500">Serial Number</span>
                            <p class="text-md font-semibold text-neutral-900">
                                {{ $inquiry->warranty->serial_number }}
                            </p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm text-neutral-500">Status</span>
                                <div class="mt-1">
                                    <x-icons.badge type="{{ $inquiry->warranty->status }}" size="sm">
                                        {{ $inquiry->warranty->status->label() }}
                                    </x-icons.badge>
                                </div>
                            </div>
                            <div>
                                <span class="text-sm text-neutral-500">Date Purchased</span>
                                <p class="text-md font-semibold text-neutral-900">
                                    {{ $inquiry->warranty->purchase_date ? $inquiry->warranty->purchase_date->format('M d, Y') : 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="border-t border-gray-300 px-5 py-2">
                        <span class="text-sm text-neutral-500">Warranty Expiration</span>
                        <div class="flex justify-between items-start mt-1">
                            <div>
                                <p class="text-md font-bold text-neutral-900">
                                    {{ $inquiry->warranty->expiry_date ? $inquiry->warranty->expiry_date->format('M d, Y') : 'N/A' }}
                                </p>
                            </div>
                            @if ($inquiry->warranty->expiry_date)
                                <div class="flex space-x-1">
                                    <x-icons.circle-badge type="{{ $inquiry->warranty->status }}" size="md" />
                                    <p
                                        class="text-md {{ $inquiry->warranty->expiry_date->isPast() ? 'text-red-800' : 'text-neutral-500' }}">
                                        @if ($inquiry->warranty->expiry_date->isPast())
                                            Expired
                                        @else
                                            {{ (int) now()->diffInDays($inquiry->warranty->expiry_date) }} days
                                            remaining
                                        @endif
                                    </p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-300 py-3 px-5">
                    <span class="text-sm text-neutral-500">Service Center</span>
                    <p class="text-md font-semibold text-neutral-900">
                        {{ $inquiry->warranty->product->service_center_name }}
                    </p>
                    <p class="text-sm text-neutral-500 mt-1 leading-snug">
                        {{ $inquiry->warranty->product->service_center_address }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    @vite(['resources/js/inquiry.js'])
</x-admin-layout>
