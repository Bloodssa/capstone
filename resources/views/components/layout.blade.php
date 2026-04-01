<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'App') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="/favicon.ico">
    <link rel="icon" type="image/png" href="{{ Vite::asset('resources/images/mark.png') }}">
</head>

<body x-data="{ open: false }" class="font-sans antialiased" x-init x-cloak>
    <header class="w-full bg-white border-b border-gray-300 sticky top-0 z-50">
        <div class="mx-auto h-18 flex justify-between items-center max-w-360.5 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center space-x-6">
                <x-icons.logo />

                <nav class="hidden lg:flex items-center space-x-2">
                    <a href="/"
                        class="text-sm font-medium bg-gray-100 py-1 px-2 rounded-sm text-neutral-700 hover:text-black transition-colors">Home</a>
                    <a href="/"
                        class="text-sm font-medium text-neutral-500 py-1 px-2 rounded-sm hover:bg-gray-100 hover:text-neutral-700 transition-colors">About</a>
                    <a href="/"
                        class="text-sm font-medium text-neutral-500 py-1 px-2 rounded-sm hover:bg-gray-100 hover:text-neutral-700 transition-colors">Warranty</a>
                    <a href="/"
                        class="text-sm font-medium text-neutral-500 py-1 px-2 rounded-sm hover:bg-gray-100 hover:text-neutral-700 transition-colors">FAQ</a>
                </nav>
            </div>

            <div class="flex items-center justify-end gap-2 shrink-0">
                <div class="hidden lg:flex items-center gap-2">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}"
                            class="px-5 py-1.5 border border-gray-300 hover:bg-gray-100 transition text-neutral-900 rounded-md text-sm font-semibold">Log
                            in</a>
                        <a href="{{ route('register') }}"
                            class="px-5 py-1.5 bg-black hover:bg-black/80 transition duration-200 text-white rounded-md text-sm font-semibold">Register</a>
                    @endif
                </div>

                <button @click="open = !open"
                    class="lg:hidden p-2 text-neutral-600 hover:bg-gray-100 rounded-md transition-colors">
                    <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                    <svg x-show="open" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            class="lg:hidden bg-white border-b border-gray-300 absolute w-full left-0 px-4 py-4 space-y-4 shadow-xl">
            <nav class="flex flex-col space-y-3">
                <a href="/" class="text-base font-medium text-neutral-900">Home</a>
                <a href="/" class="text-base font-medium text-neutral-600">About</a>
                <a href="/" class="text-base font-medium text-neutral-600">Warranty</a>
                <a href="/" class="text-base font-medium text-neutral-600">FAQ</a>
            </nav>
            <hr class="border-gray-100">
            <div class="flex flex-col gap-2 lg:hidden">
                <a href="{{ route('login') }}"
                    class="w-full text-center py-2 border border-gray-300 rounded-md text-sm font-semibold text-neutral-900">Log
                    in</a>
                <a href="{{ route('register') }}"
                    class="w-full text-center py-2 bg-black rounded-md text-sm font-semibold text-white">Register</a>
            </div>
        </div>
    </header>

    <main class="mt-10 max-w-337.5 mx-auto space-y-10 pb-15">
        {{ $slot }}
    </main>

</body>

</html>
