<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Gray Times') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600&family=crimson-text:400,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional meta tags -->
    <meta name="description" content="Sign in to your {{ config('app.name', 'Laravel') }} account">
</head>
<body class="font-sans antialiased text-gray-900 bg-white">
    <!-- Subtle background pattern -->
    <div class="fixed inset-0 opacity-5 pointer-events-none">
        <svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg">
            <g fill="none" fill-rule="evenodd">
                <g fill="#374151" fill-opacity="0.1">
                    <circle cx="30" cy="30" r="1"/>
                </g>
            </g>
        </svg>
    </div>

    <!-- Main content -->
    <div class="relative min-h-screen flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8">
        <!-- Simple brand section -->
        <div class="mb-16">
            <a href="/" class="group flex flex-col items-center space-y-3 transition-all duration-300">
                <!-- Simple logo -->
                <div class="flex items-center justify-center w-12 h-12 bg-gray-100 rounded-full group-hover:bg-gray-200 transition-colors duration-300">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                </div>
                <!-- Brand name -->
                <h1 class="text-xl font-light text-gray-900 serif tracking-wide">
                    {{ config('app.name', 'Journal') }}
                </h1>
            </a>
        </div>

        <!-- Content area -->
        <div class="w-full max-w-md">
            @yield('content')
        </div>

        <!-- Minimal footer -->
        <div class="mt-16 text-center">
            <p class="text-xs text-gray-400 tracking-wide">
                &copy; {{ date('Y') }} {{ config('app.name', 'Journal') }}
            </p>
        </div>
    </div>
</body>
</html>