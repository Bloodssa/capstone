<x-admin-layout>

    @php
        $status = [
            'open' => 0,
            'pending' => 1,
            'in-progress' => 2,
            'resolved' => 3,
            'replaced' => 3,
            'closed' => 3,
        ];

        $currentStatus = $status[$inquiry->status] ?? 0;

        $progress = [
            'open' => [
                'label' => 'Open',
                'path' =>
                    'M538.5-138.5Q480-197 480-280t58.5-141.5Q597-480 680-480t141.5 58.5Q880-363 880-280t-58.5 141.5Q763-80 680-80t-141.5-58.5ZM747-185l28-28-75-75v-112h-40v128l87 87Zm-547 65q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h167q11-35 43-57.5t70-22.5q40 0 71.5 22.5T594-840h166q33 0 56.5 23.5T840-760v250q-18-13-38-22t-42-16v-212h-80v120H280v-120h-80v560h212q7 22 16 42t22 38H200Zm308.5-651.5Q520-783 520-800t-11.5-28.5Q497-840 480-840t-28.5 11.5Q440-817 440-800t11.5 28.5Q463-760 480-760t28.5-11.5Z',
            ],
            'pending' => [
                'label' => 'Pending',
                'path' =>
                    'm612-292 56-56-148-148v-184h-80v216l172 172ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z',
            ],
            'processing' => [
                'label' => 'Processing',
                'path' =>
                    'M314-115q-104-48-169-145T80-479q0-26 2.5-51t8.5-49l-46 27-40-69 191-110 110 190-70 40-54-94q-11 27-16.5 56t-5.5 60q0 97 53 176.5T354-185l-40 70Zm306-485v-80h109q-46-57-111-88.5T480-800q-55 0-104 17t-90 48l-40-70q50-35 109-55t125-20q79 0 151 29.5T760-765v-55h80v220H620ZM594 0 403-110l110-190 69 40-57 98q118-17 196.5-107T800-480q0-11-.5-20.5T797-520h81q1 10 1.5 19.5t.5 20.5q0 135-80.5 241.5T590-95l44 26-40 69Z',
            ],
            'finished' => [
                'label' => 'Finished',
                'path' =>
                    'm424-296 282-282-56-56-226 226-114-114-56 56 170 170Zm56 216q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z',
            ],
        ];
    @endphp

    <div class="lg:py-6 md:px-6 lg:px-10 max-w-7xl mx-auto w-full space-y-6">

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

        <div class="bg-white border border-gray-300 rounded-md py-6">
            <div class="flex items-center justify-between max-w-4xl mx-auto relative">
                @foreach ($progress as $key => $prog)
                    <div class="flex flex-col items-center z-10">
                        <div
                            class="w-14 h-14 rounded-full flex items-center justify-center border 
                            {{ $currentStatus >= $loop->index ? 'bg-neutral-900 border-neutral-500' : 'bg-white border-gray-300' }}">
                            <svg class="w-7 h-7 {{ $currentStatus >= $loop->index ? 'text-white' : 'text-gray-400' }}"
                                viewBox="0 -960 960 960" fill="currentColor">
                                <path d="{{ $prog['path'] }}" />
                            </svg>
                        </div>
                        <p
                            class="mt-2 text-sm font-semibold {{ $currentStatus >= $loop->index ? 'text-neutral-900' : 'text-neutral-500' }}">
                            {{ $prog['label'] }}
                        </p>
                    </div>
                    @if (!$loop->last)
                        <div class="flex-1 h-0.5 mx-2 bg-gray-300 relative -top-3">
                            <div
                                class="h-full bg-neutral-900 transition-all duration-300 {{ $currentStatus > $loop->index ? 'w-full' : 'w-0' }}">
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

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

                <div class="flex-1 overflow-y-auto p-5 space-y-4 bg-white">
                    @foreach ($messages as $msg)
                        @php
                            $isCustomer = $msg->user->id === $inquiry->user->id;
                        @endphp
                        <div class="flex {{ $isCustomer ? 'justify-start' : 'justify-end' }}">
                            <div class="flex items-end gap-2 {{ $isCustomer ? '' : 'flex-row-reverse' }}">
                                @if ($isCustomer)
                                    <div class="shrink-0">
                                        <x-icons.avatar :name="$msg->user->name" size="sm" />
                                    </div>
                                @endif
                                <div class="flex flex-col {{ $isCustomer ? 'items-start' : 'items-end' }}">
                                    <div
                                        class="p-2 rounded-md text-sm max-w-md wrap-break-word
                                        {{ $isCustomer ? 'bg-gray-100 text-neutral-900' : 'bg-neutral-900 text-white' }}">
                                        {{ $msg->message }}
                                    </div>
                                    @if ($msg->attachments)
                                        <div
                                            class="flex flex-wrap max-w-100 gap-1 mt-2 {{ $isCustomer ? 'justify-start' : 'justify-end' }}">
                                            @foreach ($msg->attachments as $path)
                                                <a href="{{ asset('storage/' . $path) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $path) }}"
                                                        class="h-24 w-24 object-cover rounded-md border border-gray-200">
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <x-ui.reply :action="route('inquiry-response')" buttonText="Response" placeholder="Response to the inquiry of the user">
                    <x-slot name="hiddenInputs">
                        <input type="hidden" name="warranty_inquiries_id" value="{{ $inquiry->id }}">
                    </x-slot>
                </x-ui.reply>
            </div>

            <div class="space-y-4">
                <div class="bg-white border border-gray-300 rounded-md">
                    <div class="px-5 py-4 border-b border-gray-300">
                        <h1 class="text-neutral-900 font-semibold text-base">
                            Update Progress
                        </h1>
                    </div>
                    <form action="/warranty-status/{{ $inquiry->id }}" method="POST" class="space-y-4 p-5">
                        @csrf
                        @method('PATCH')
                        <select name="status"
                            class="w-full border-gray-300 rounded-md text-sm focus:ring-neutral-900 focus:border-neutral-900">
                            <option value="pending" @selected($inquiry->status == 'pending')>Pending</option>
                            <option value="in-progress" @selected($inquiry->status == 'in-progress')>In-Progress</option>
                            <option value="resolved" @selected($inquiry->status == 'resolved')>Resolved</option>
                            <option value="replaced" @selected($inquiry->status == 'replaced')>Replaced</option>
                            <option value="closed" @selected($inquiry->status == 'closed')>Closed</option>
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
                                        {{ Str::title($inquiry->warranty->status) }}
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
                                        class="text-md {{ $inquiry->warranty->expiry_date->isPast() ? 'text-red-600' : 'text-neutral-500' }}">
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
</x-admin-layout>
