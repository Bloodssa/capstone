<x-app-layout>

    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-900">
            Hello, {{ Str::before(Auth::user()->name, ' ') ?? 'Guest' }}
        </h1>
        <p class="text-neutral-500 mt-2 text-md">Monitor your warranties, track claims, and never miss an expiration
            date.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-ui.summary :count="$activeWarranties" title="Active Warranties" :url="route('warranty')"
            icon="M438-226 296-368l58-58 84 84 168-168 58 58-226 226ZM200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Z" />
        <x-ui.summary :count="$expWarCount" title="Expiring Soon" :url="route('warranty')"
            icon="M593-567q47-47 47-113v-120H320v120q0 66 47 113t113 47q66 0 113-47ZM160-80v-80h80v-120q0-61 28.5-114.5T348-480q-51-32-79.5-85.5T240-680v-120h-80v-80h640v80h-80v120q0 61-28.5 114.5T612-480q51 32 79.5 85.5T720-280v120h80v80H160Z" />
        <x-ui.summary :count="$resolvedInquiryCount" title="Resolved Claims" :url="route('warranty')"
            icon="M480-400ZM80-160v-400q0-33 23.5-56.5T160-640h120v-80q0-33 23.5-56.5T360-800h240q33 0 56.5 23.5T680-720v80h120q33 0 56.5 23.5T880-560v400H80Zm240-200v40h-80v-40h-80v120h640v-120h-80v40h-80v-40H320ZM160-560v120h80v-40h80v40h320v-40h80v40h80v-120H160Zm200-80h240v-80H360v80Z" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 mt-10 gap-6">
        <x-ui.customer.summary title="Recent Purchase" :isEmpty="$recentlyPurchased->isEmpty()" :products="$recentlyPurchased" />
        <x-ui.customer.summary title="Expiring Warranties" :expiring="true" :isEmpty="$expiringWarranties->isEmpty()" :products="$expiringWarranties" emptyTitle="No expiring product" emptySubTitle="No product near-expiry or expired" />
    </div>
</x-app-layout>
