{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Blog' }} - {{ config('ReadItt') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

</head>
<body class="min-h-screen bg-gray-50/30">
    
    <!-- Navigation -->
    <x-nav />

    <!-- Flash Messages -->
    <x-snackbar />

    <!-- Main Content -->
    <main class="pt-20">
        <div class="max-w-5xl mx-auto py-12 px-6">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <x-footer />

    @stack('scripts')
</body>
</html>