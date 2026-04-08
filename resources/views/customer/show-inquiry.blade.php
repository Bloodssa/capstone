<x-app-layout>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('inquiries') }}" class="p-2 hover:bg-gray-100 rounded-full transition text-neutral-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-xl font-bold text-neutral-900">
                    Inquiry for {{ $inquiry->warranty->product->name }}
                </h1>
                <p class="text-xs text-neutral-500">
                    {{ ucfirst($inquiry->status) }}
                </p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('warranty.show', $inquiry->warranty->id) }}"
                class="px-4 py-2 border border-gray-300 bg-neutral-900 text-white text-sm font-semibold rounded-md">
                View Chats
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-gray-300 rounded-md">
                <div class="px-5 py-4 border-b border-gray-300">
                    <h2 class="text-neutral-900 font-semibold text-base">Inquiry Details</h2>
                </div>

                <div class="px-5 py-4 space-y-4">
                    <div class="flex justify-between">
                        <span class="text-sm text-neutral-500">Status</span>
                        <x-icons.badge type="{{ $inquiry->status }}" size="sm">
                            {{ Str::title($inquiry->status) }}
                        </x-icons.badge>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-sm text-neutral-500">Created</span>
                        <span class="text-sm font-semibold text-neutral-900">
                            {{ $inquiry->created_at->format('M d, Y h:i A') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-sm text-neutral-500">Last Updated</span>
                        <span class="text-sm font-semibold text-neutral-900">
                            {{ $inquiry->updated_at->format('M d, Y h:i A') }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="bg-white border border-gray-300 rounded-md overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-300">
                    <h2 class="text-neutral-900 font-semibold text-base">Issue Message</h2>
                </div>

                <div class="p-5">
                    <p class="text-neutral-900">
                        {{ $inquiry->message }}
                    </p>
                    <div class="mt-6 pt-4 border-t border-gray-300">
                        @if ($inquiry->attachments && count($inquiry->attachments))
                            <div class="flex flex-wrap gap-2">
                                @foreach ($inquiry->attachments as $path)
                                    <a href="{{ asset('storage/' . $path) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $path) }}"
                                            class="h-20 w-20 object-cover rounded-md border border-gray-300 hover:opacity-80 transition">
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-neutral-500">No attachments</p>
                        @endif
                    </div>
                </div>
            </div>
            @if ($inquiry->warranty->resolved_message)
                <div class="bg-white border border-gray-300 rounded-md">
                    <div class="px-5 py-4 border-b border-gray-300">
                        <h2 class="text-neutral-900 font-semibold text-base">Resolution</h2>
                    </div>

                    <div class="p-5">
                        <p class="text-neutral-900">
                            {{ $inquiry->warranty->resolved_message }}
                        </p>
                    </div>
                </div>
            @else
                <div class="bg-white border border-gray-300 rounded-md p-5 text-sm text-neutral-500">
                    @if ($inquiry->status === 'pending')
                        <p class="text-sm text-neutral-500">
                            Your inquiry has been received and is waiting for review.
                        </p>
                    @elseif($inquiry->status === 'in_progress')
                        <p class="text-sm text-neutral-500">
                            Your inquiry is currently being reviewed.
                        </p>
                    @else
                        <p class="text-sm text-neutral-500">
                            Awaiting for updates.
                        </p>
                    @endif
                </div>
            @endif
        </div>
        <div class="space-y-6">
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
                                <x-icons.badge type="{{ $inquiry->warranty->status->label() }}" size="sm">
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
</x-app-layout>
