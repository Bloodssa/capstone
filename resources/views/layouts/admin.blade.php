<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon" href="/favicon.ico">

    <link rel="icon" type="image/png" href="{{ Vite::asset('resources/images/mark.png') }}">
</head>

<body class="font-sans antialiased" x-data="{
    sidebarOpen: window.innerWidth >= 1024,
    isLargeScreen: window.innerWidth >= 1024
}" x-init="$watch('isLargeScreen', value => sidebarOpen = value)"
    @resize.window="isLargeScreen = window.innerWidth >= 1024" x-cloak>
    <div class="min-h-screen bg-gray-100">
        <div x-show="sidebarOpen && !isLargeScreen" x-transition:enter="transition opacity-100 duration-300"
            x-transition:enter-start="opacity-0" x-transition:leave="transition opacity-0 duration-200"
            @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black/50 lg:hidden"></div>

        @if (!request()->is('/'))
            @include('layouts.aside')
        @endif

        <div class="flex flex-col flex-1 transition-all duration-300"
            :class="isLargeScreen && sidebarOpen ? 'pl-60' : 'pl-0'">
            @include('layouts.manager-header')
            @props([
                'header' => true,
                'title' => 'Admin Dashboard',
                'subtitle' => 'Monitor warranties, manage customers, and respond to repair inquiries in one place',
            ])
            <main class="pt-24 p-6 h-auto">
                <div class="lg:py-6 md:px-6 lg:px-10 max-w-6xl mx-auto w-full space-y-6">
                    @if($header)
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="space-y-1">
                                <h1 class="text-neutral-900 text-2xl font-bold">{{ $title }}</h1>
                                <p class="text-neutral-500 text-sm">{{ $subtitle }}</p>
                            </div>
                            @if (isset($controls))
                                <div class="shrink-0">
                                    {{ $controls }}
                                </div>
                            @endif
                        </div>
                    @endif
                    <div class="w-full">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>
