@props(['notifications'])

<div x-data="{ notificationModal: false }" @open-notifications.window="notificationModal = true" x-show="notificationModal" x-cloak
    @click.outside="notificationModal = false" @keydown.escape.window="notificationModal = false"
    class="fixed z-100 bottom-4 left-4 right-4 sm:top-20 sm:right-6 sm:left-auto sm:bottom-auto
           w-auto sm:w-98 sm:right
           max-h-[80vh] overflow-y-auto
           bg-white rounded-md border border-gray-200">

</div>
