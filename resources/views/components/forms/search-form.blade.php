@props(['route' => '/', 'placeholder' => 'Search product name or serial number'])

<form action="{{ route($route) }}" method="GET" id="{{ $id ?? 'searchForm' }}" class="w-full">
    <div class="relative w-full">
        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-neutral-500 z-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>

        <x-forms.text-input type="text" :icon="true" name="search" :value="request('search')" :placeholder="$placeholder ?? 'Search...'"
            class="w-full h-10 pl-10" x-data x-on:input.debounce.500ms="$el.form.submit()" />
    </div>
</form>
