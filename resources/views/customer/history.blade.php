<x-app-layout>
    <div>
        <div class="pb-4 mb-4">
            <h2 class="text-2xl font-bold text-gray-900">Account History</h2>
            <p class="text-sm text-gray-500">Track your product registrations and support inquiries.</p>
        </div>
        <div class="mx-auto">
            <div class="bg-white overflow-hidden border border-gray-300 sm:rounded-md">
                <div class="divide-y divide-gray-300">
                    @forelse($history as $event)
                        <x-ui.customer.history-item :type="$event->type" :url="$event->url" :title="$event->title" :description="$event->description"
                            :date="$event->date" />
                    @empty
                        <div class="px-4 py-35 text-center">
                            <x-ui.is-empty title="No History Yet"
                                subTitle="Purchase a product  on our shop or open an inquiry to see your history here." />
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
