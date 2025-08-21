<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin - {{ config('app.name', 'Blog') }} @yield('title')</title>

    <!-- Fonts -->
    {{-- <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=crimson-text:400,600,700&display=swap" rel="stylesheet" /> --}}

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-gray-50">
    <!-- Sidebar -->
    <x-admin-nav :dashboard-data="$dashboardData" />
    
    <!-- Page Content -->
    <main class="lg:pt-0 lg:ml-64 min-h-screen">
        <div class="mx-auto py-8 px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
        <x-snackbar />
    </main>
    
</body>
</html>