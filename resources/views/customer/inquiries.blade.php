<x-app-layout>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-neutral-900">Support Inquiries</h1>
            <p class="text-sm text-neutral-500">Track and manage your warranty claims.</p>
        </div>
        <div class="flex flex-col md:flex-row gap-2 w-full md:max-w-2xl items-stretch md:items-center">
            <div class="flex-1 min-w-0">
                <x-forms.search-form route="inquiries" />
            </div>
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                    class="h-10 px-4 bg-white border border-gray-300 rounded-md text-sm font-medium">
                    Filter by Status
                </button>
                <div x-show="open" @click.outside="open = false"
                    class="absolute right-0 mt-2 w-48 bg-white border border-gray-300 rounded-md z-50 overflow-hidden">
                    <a href="{{ route('inquiries', ['search' => request('search')]) }}"
                        class="block px-4 py-2 text-sm hover:bg-gray-100 {{ !request('status') ? 'bg-gray-100 font-semibold' : '' }}">
                        All
                    </a>
                    @foreach (\App\Enum\InquiryStatusType::cases() as $status)
                        <a href="{{ route('inquiries', ['status' => $status->value, 'search' => request('search')]) }}"
                            class="block px-4 py-2 text-sm hover:bg-gray-100 {{ request('status') === $status->value ? 'bg-gray-100 font-semibold' : '' }}">
                            {{ $status->label() }}
                        </a>
                    @endforeach
                </div>
            </div>
            <button class="h-10 px-4 bg-neutral-900 text-white rounded-md text-sm font-medium">
                New Inquiry
            </button>
        </div>
    </div>

    @if ($inquiries->count())
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            @foreach ($inquiries as $inquiry)
                <a href="{{ route('inquiry.show', $inquiry->id) }}"
                    class="group relative bg-white border border-gray-300 rounded-md cursor-pointer">
                    <div class="flex justify-between pt-5 px-5">
                        <h3 class="text-lg font-bold text-neutral-900 mb-1">
                            {{ $inquiry->warranty->product->name }}
                        </h3>

                        <x-icons.badge type="{{ $inquiry->status }}" size="sm">
                            {{ $inquiry->status->label() }}
                        </x-icons.badge>
                    </div>

                    <p class="text-sm text-neutral-500 line-clamp-2 px-5 mb-4">
                        {{ $inquiry->message }}
                    </p>

                    <div class="flex items-center gap-3 pt-4 border-t p-5 border-gray-300">
                        <img src="{{ asset('storage/' . $inquiry->warranty->product->product_image_url) }}"
                            alt="{{ $inquiry->warranty->product->name }}"
                            class="w-14 h-14 rounded-md object-cover border border-neutral-200">
                        <div class="flex-1">
                            <p class="text-xs font-bold text-neutral-900">
                                {{ $inquiry->warranty->product->brand }} -
                                {{ $inquiry->warranty->product->category }}
                            </p>

                            <p class="text-xs text-neutral-500">
                                Warranty: {{ $inquiry->warranty->status->label() }}
                            </p>
                            <p class="text-xs text-neutral-500 font-semibold">
                                Updated {{ $inquiry->updated_at->diffForHumans() }}
                            </p>
                        </div>
                        <div class="text-right text-neutral-900">
                            <p class="text-sm font-semibold">Serial Number</p>
                            <p class="text-sm">{{ $inquiry->warranty->serial_number }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div
            class="flex flex-col items-center justify-center bg-white border rounded-md border-gray-300 w-full min-h-[50vh]">
            @php
                $hasFilters = request('search') || request('status');
            @endphp
            @if ($hasFilters)
                <x-ui.is-empty title="No matching inquiries found" subTitle="Try adjusting your search or status filter" />
                <a href="{{ route('inquiries') }}" class="mt-4 inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-neutral-900 rounded-md">
                    Clear filters
                </a>
            @else
                <x-ui.is-empty title="No inquiries yet" subTitle="You haven’t created any support inquiries for your warranties yet" />
                <a href="{{ route('warranty') }}" class="mt-4 inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-neutral-900 rounded-md">
                    Browse warranties
                </a>
            @endif
        </div>
    @endif
</x-app-layout>
