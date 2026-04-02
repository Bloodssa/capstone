@props(['notifications'])

<div x-show="notificationModal" x-cloak @click.outside="notificationModal = false"
    @keydown.escape.window="notificationModal = false" x-transition:enter="transition ease-out duration-50"
    x-transition:enter-start="opacity-0 scale-95"
    class="absolute z-50 top-full right-0 mt-2 w-80 sm:w-96 max-h-[75vh] overflow-hidden bg-white rounded-md border border-gray-300">
    <div class="p-4 border-b border-gray-300 flex justify-between items-center bg-gray-50/50">
        <h2 class="text-xs font-bold text-neutral-900">Notifications</h2>
    </div>
    <div class="overflow-y-auto max-h-[60vh] divide-y divide-gray-300">
        @forelse($notifications as $notif)
            @php
                $iconClass = match ($notif->type) {
                    'warning' => 'bg-yellow-700 border-orange-200',
                    'error' => 'bg-red-700 border-red-200',
                    default => 'bg-blue-700 border-blue-200',
                };
            @endphp
            <div class="flex items-start gap-3 p-4">
                <div class="relative flex h-8 w-8 flex-none items-center justify-center">
                    <div class="h-3 w-3 rounded-full {{ $iconClass }} ring-4 ring-white"></div>
                </div>
                <div class="flex-1">
                    <p class="text-sm text-gray-900">
                        {{ $notif->message }}
                    </p>
                </div>
            </div>
        @empty
            <div class="p-10 text-center">
                <p class="text-xs text-gray-400">No notifications</p>
            </div>
        @endforelse
    </div>
    <div class="p-3 bg-gray-50 text-center border-t border-gray-300">
        <a href="{{ route('history') }}" class="text-xs font-bold text-neutral-900 hover:underline">View
            History</a>
    </div>
</div>
