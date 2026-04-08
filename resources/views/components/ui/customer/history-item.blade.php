@props(['type', 'title', 'description', 'date', 'url'])

@php
    $checkIcon =
        'm424-296 282-282-56-56-226 226-114-114-56 56 170 170Zm56 216q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z';

    $expireIcon =
        'M593-567q47-47 47-113v-120H320v120q0 66 47 113t113 47q66 0 113-47ZM160-80v-80h80v-120q0-61 28.5-114.5T348-480q-51-32-79.5-85.5T240-680v-120h-80v-80h640v80h-80v120q0 61-28.5 114.5T612-480q51 32 79.5 85.5T720-280v120h80v80H160Z';

    $config = match ($type) {
        'success' => [
            'bgClass' => 'bg-green-50 border-green-200',
            'textClass' => 'text-green-800',
            'icon' => $checkIcon,
        ],
        'expire' => [
            'bgClass' => 'bg-red-50 border-red-200',
            'textClass' => 'text-red-800',
            'icon' => $expireIcon,
        ],
        default => [
            'bgClass' => 'bg-blue-50 border-blue-200',
            'textClass' => 'text-blue-700',
            'icon' => $checkIcon,
        ],
    };
@endphp

<div class="group relative flex items-start gap-x-4 p-4 last:border-0">
    <div
        class="relative flex h-10 w-10 flex-none items-center justify-center rounded-full border {{ $config['bgClass'] }}">
        <svg xmlns="http://www.w3.org/2000/svg" height="22" viewBox="0 -960 960 960" width="22" fill="currentColor"
            class="{{ $config['textClass'] }}">
            <path d="{{ $config['icon'] }}" />
        </svg>
    </div>

    <div class="flex-auto">
        <div class="flex justify-between items-baseline gap-x-4">
            <h3 class="text-sm font-semibold leading-6 text-gray-900">
                {{ $title }}
            </h3>
            <time datetime="{{ $date }}" class="flex-none text-xs text-gray-400">
                {{ $date->format('M d, Y') }}
            </time>
        </div>
        <div class="flex justify-between">
            <p class="mt-0.5 text-sm leading-6 text-gray-500">
                {{ $description }}
            </p>
            <a class="mt-2 text-neutral-900 font-semibold hover:underline text-xs" href="{{ $url }}">
                View More
            </a>
        </div>
    </div>
</div>
