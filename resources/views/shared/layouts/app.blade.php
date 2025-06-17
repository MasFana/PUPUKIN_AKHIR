<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', 'Pupukin')</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net" rel="preconnect">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <script src="//unpkg.com/alpinejs" defer></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        @stack('head')

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        @endif
    </head>

    <body class="min-h-screen w-full bg-[#FDFDFC]">
        @if (Auth::check())
            @if (Auth::user()->role == 'admin')
                <x-navbar-admin />
            @elseif(Auth::user()->role == 'owner')
                <x-navbar-owner />
            @elseif (Auth::user()->role == 'customer')
                <x-navbar />
            @endif
        @else
            @if (!Request::is('login*') && !Request::is('register*'))
                <x-navbar-guest />
            @endif

        @endif

        @yield('content')
    </body>
        <!-- Footer -->
        <footer class="bg-green-900 py-8 text-white">
            <div class="container mx-auto px-4 text-center">
                <p>&copy; <span id="current-year"></span> Pupukin App. All rights reserved.</p>
            </div>
        </footer>
    @stack('scripts')

</html>
