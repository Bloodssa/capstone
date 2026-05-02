@props([
    'select',
    'route' => '/',
    'name' => 'status',
    'statusRoute' => '/',
    'placeholder' => 'Search',
    'dropdown' => false,
    'px' => false,
    'all' => false
])

<div class="{{ $px ? '' : 'px-4' }} py-3 flex flex-col md:flex-row gap-4 justify-between items-center bg-gray-50/50 w-full">
    <div class="relative w-full md:w-96">
        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-neutral-500 group-focus-within:text-gray-600 z-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-neutral-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <x-forms.search-form placeholder="{{ $placeholder }}" route="{{ $route }}" />
    </div>

    @if (!$dropdown)
        <div class="flex items-center gap-2 w-full md:w-auto">
            <form action="{{ route($statusRoute) }}" method="GET" class="flex gap-2 w-full">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <x-forms.select placeholder="All" name="{{ $name }}" :options="$select" :selected="request($name)" onchange="this.form.submit()" />
            </form>
            <div class="shrink-0">
                {{ $slot }}
            </div>
        </div>
    @endif
</div>
