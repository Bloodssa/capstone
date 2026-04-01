@props(['color', 'svg', 'count' => 0, 'title', 'url', 'icon' => 'M480-400ZM80-160v-400q0-33 23.5-56.5T160-640h120v-80q0-33 23.5-56.5T360-800h240q33 0 56.5 23.5T680-720v80h120q33 0 56.5 23.5T880-560v400H80Zm240-200v40h-80v-40h-80v120h640v-120h-80v40h-80v-40H320ZM160-560v120h80v-40h80v40h320v-40h80v40h80v-120H160Zm200-80h240v-80H360v80Z'])

@php
    $colors = [
        'amber' => 'bg-amber-50 text-amber-600',
        'emerald' => 'bg-emerald-50 text-emerald-600',
        'blue' => 'bg-blue-50 text-blue-600',
    ];

    $colorClasses = $colors[$color] ?? 'bg-gray-50 text-gray-600';
@endphp

<div class="border border-gray-300 border-l-neutral-900 border-l-4 rounded-md p-5 bg-white">
    <div class="flex justify-between items-start">
        <div class="w-10 h-10 rounded-md bg-neutral-100 flex items-center justify-center text-neutral-900">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="font-normal w-6 h-6"
                fill="currentColor">
                <path
                    d="{{ $icon }}" />
            </svg>
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
