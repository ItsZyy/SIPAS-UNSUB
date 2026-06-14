<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'SIPAS UNSUB') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-icon.png') }}">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="min-h-screen flex flex-col items-center justify-center px-4 sm:px-6">
            <div class="flex flex-col items-center text-center max-w-lg mx-auto">
                <h1 class="text-4xl sm:text-5xl font-extrabold text-indigo-600 tracking-tight leading-tight">
                    SIPAS UNSUB
                </h1>
                <p class="mt-2 text-sm sm:text-base text-gray-400 font-medium">
                    Smart Letter Archiving System
                </p>

                <div class="mt-8 sm:mt-10 w-full max-w-sm">
                    <img src="{{ asset('images/splash.svg') }}" alt="Splash Illustration" class="w-full h-auto">
                </div>

                <p class="mt-8 sm:mt-10 text-sm text-gray-400 animate-pulse">
                    Memuat aplikasi...
                </p>
            </div>
        </div>

        <script>
            (function() {
                var redirectUrl = '{{ Auth::check() ? route("dashboard") : route("login") }}';
                setTimeout(function() {
                    window.location.href = redirectUrl;
                }, 1900);
            })();
        </script>
    </body>
</html>
