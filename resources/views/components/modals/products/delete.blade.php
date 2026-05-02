@props(['data', 'title', 'name', 'route'])

<div x-show="{{ $data }}" x-cloak
    class="fixed inset-0 flex items-center justify-center p-5 overflow-y-auto z-9999 text-left">
    <div class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-sm" @click="{{ $data }} = false"></div>
    <div @click.outside="{{ $data }} = false" class="no-scrollbar relative flex w-full max-w-122.5 max-h-[90vh] flex-col overflow-y-auto rounded-xl bg-white p-6 lg:p-11 shadow-2xl">
        <button @click="{{ $data }} = false" class="transition-all absolute right-5 top-5 z-10 flex h-11 w-11 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200">
            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24">
                <path d="M6.04289 16.5418C5.65237 16.9323 5.65237 17.5655 6.04289 17.956C6.43342 18.3465 7.06658 18.3465 7.45711 17.956L11.9987 13.4144L16.5408 17.9565C16.9313 18.347 17.5645 18.347 17.955 17.9565C18.3455 17.566 18.3455 16.9328 17.955 16.5423L13.4129 12.0002L17.955 7.45808C18.3455 7.06756 18.3455 6.43439 17.955 6.04387C17.5645 5.65335 16.9313 5.65335 16.5408 6.04387L11.9987 10.586L7.45711 6.04439C7.06658 5.65386 6.43342 5.65386 6.04289 6.04439C5.65237 6.43491 5.65237 7.06808 6.04289 7.4586L10.5845 12.0002L6.04289 16.5418Z" />
            </svg>
        </button>
        <div class="flex items-center justify-center">
            <div class="mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-red-50 text-red-500">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
        </div>

        <div class="flex flex-col items-center px-4">
            <h4 class="mb-3 text-2xl font-bold text-gray-800">
                {{ $title }}
            </h4>

            <p class="mb-8 text-sm text-gray-500 text-center max-w-sm">
                Are you sure you want to delete:
                <span class="text-neutral-900 font-semibold">
                    {{ $name }}
                </span>
            </p>
        </div>

        <form method="POST" action="{{ $route }}"
            class="flex w-full flex-col-reverse gap-3 sm:flex-row sm:justify-center">
            @csrf
            @method('DELETE')

            <button type="button"
                @click="{{ $data }} = false"
                class="px-6 py-2.5 text-sm font-semibold text-neutral-900 bg-white border border-gray-300 rounded-md hover:bg-gray-200 transition">
                Cancel
            </button>

            <button type="submit"
                class="flex w-full sm:w-auto justify-center rounded-md bg-red-400 px-8 py-3 text-sm font-semibold text-white hover:bg-red-500">
                Yes, Delete
            </button>
        </form>
    </div>
</div>