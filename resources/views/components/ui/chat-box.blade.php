@props(['messages'])

<div class="flex-1 overflow-y-auto p-5 space-y-4 bg-white">
    @foreach ($messages as $msg)
        @php
            $isCustomer = $msg->type === 'message' && $msg->user?->id === auth()->id();
        @endphp

        @if ($msg->type === 'updates')
            <div class="relative flex items-center justify-center my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative bg-white px-4 flex flex-col items-center text-center">
                    <span class="text-sm font-semibold text-neutral-500">
                        {{ $msg->message }}
                    </span>
                    <span class="text-xs text-neutral-400 mt-0.5">
                        {{ $msg->created_at->format('M d, g:i A') }}
                    </span>
                </div>
            </div>
        @elseif ($msg->type === 'solution')
            <div class="my-10 flex justify-center px-4">
                <div class="max-w-md w-full border border-gray-300 rounded-md p-6 bg-white">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2 bg-neutral-900 rounded-md text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-neutral-900">Inquiry
                                {{ $msg->status }}</h3>
                            <p class="text-xs text-neutral-500">{{ $msg->created_at->format('F j, Y') }}</p>
                        </div>
                    </div>
                    <div class="text-sm text-neutral-900 font-medium">
                        "{{ $msg->message }}"
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-300 flex justify-between items-center">
                        <span class="text-sm font-semibold text-neutral-500">{{ $msg->user->name }}</span>
                        <x-icons.badge type="{{ $msg->status }}" size="sm">
                            {{ $msg->status->label() }}
                        </x-icons.badge>
                    </div>
                </div>
            </div>
        @else
            <div class="flex {{ $isCustomer ? 'justify-end' : 'justify-start' }}">
                <div class="flex items-end gap-2 {{ $isCustomer ? 'flex-row-reverse' : 'items-start' }}">
                    @if (!$isCustomer)
                        <div class="shrink-0">
                            <x-icons.avatar :name="$msg->user?->name ?? 'System'" size="sm" />
                        </div>
                    @endif

                    <div class="flex flex-col {{ $isCustomer ? 'items-end' : 'items-start' }}">
                        <div
                            class="p-2 rounded-md text-sm max-w-md wrap-break-word {{ $isCustomer ? 'bg-neutral-900 text-white' : 'bg-gray-100 text-neutral-900' }}">
                            {{ $msg->message }}
                        </div>

                        @isset($msg->attachments)
                            <div
                                class="flex flex-wrap max-w-100 gap-1 mt-2 {{ $isCustomer ? 'justify-end' : 'justify-start' }}">
                                @foreach ($msg->attachments as $index => $path)
                                    <a href="{{ asset('storage/' . $path) }}" >
                                        <img src="{{ asset('storage/' . $path) }}"
                                            class="h-24 w-24 object-cover rounded-md border border-gray-200 hover:opacity-80 transition">
                                    </a>
                                @endforeach
                            </div>
                        @endisset

                        <span class="text-xs text-gray-500 mt-1">
                            @if ($msg->created_at->greaterThan(now()->subDay()))
                                {{ $msg->created_at->diffForHumans() }}
                            @else
                                {{ $msg->created_at->format('F j, Y, g:i a') }}
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>
