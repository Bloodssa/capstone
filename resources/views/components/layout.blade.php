<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'App') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased text-white flex flex-col items-center min-h-screen font-normal">
    <header class="w-full bg-theme-blue">
        <div class="max-w-337.5 mx-auto h-20 flex justify-between items-center px-2 md:px-8">
            <a href="/" class="font-semibold text-[12px] md:text-[16px]">Logo</a>
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-2">
                    <a href="{{ route('login') }}"
                        class="px-5 py-1.5 hover:bg-theme-hover outline-none border border-transparent transition-colors duration-200 hover:border-white text-white rounded-sm text-sm font-semibold">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="px-5 py-1.5 bg-white hover:bg-theme-hover hover:text-white hover:border-white border transition-colors duration-200 text-theme-blue rounded-sm text-sm font-semibold">
                            Register
                        </a>
                    @endif
                </nav>
            @endif
        </div>
    </header>

    <main class="mt-10 max-w-242 mx-auto space-y-10 pb-15">
        {{ $slot }}
    </main>

</body>

</html>
