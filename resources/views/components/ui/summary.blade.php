@props(['svg', 'count' => 0, 'title', 'url', 'icon'])

<div class="border border-gray-300 border-l-neutral-900 border-l-4 rounded-md p-5 bg-white">
    <div class="flex justify-between items-start">
        <div class="w-10 h-10 rounded-md bg-neutral-100 flex items-center justify-center text-neutral-900">
            <x-icons.svg :active="true" :path="$icon" :viewBox="'0 -960 960 960'" size="w-6 h-6" />
        </div>
    </div>
    <div class="mt-4">
        <p class="text-sm font-medium text-neutral-500">{{ $title }}</p>
        <div class="flex justify-between items-end mt-2">
            <h2 class="text-2xl font-bold text-gray-800">{{ $count }}</h2>
            <a href="{{ $url }}"
                class="text-xs font-semibold text-neutral-500 hover:underline hover:text-neutral-900">View All</a>
        </div>
    </div>
</div>
