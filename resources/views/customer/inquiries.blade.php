<x-app-layout>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-neutral-900">Support Inquiries</h1>
            <p class="text-sm text-neutral-500">Track and manage your warranty claims.</p>
        </div>
        <div class="flex gap-2">
            <form action="" method="GET">
                <div class="relative flex-1 group">
                    <div
                        class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-neutral-500 group-focus-within:text-gray-600 z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-neutral-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <x-forms.text-input type="text" :icon="true" placeholder="Search Warranties..." />
                </div>
            </form>
            <button class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium">
                Filter by Date
            </button>
            <button class="px-4 py-2 bg-neutral-900 text-white rounded-md text-sm font-medium">
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
                            {{ Str::title($inquiry->status) }}
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
            <x-ui.is-empty title="No inquiries yet" subTitle="No support inquiries found." />
        </div>
    @endif
</x-app-layout>
