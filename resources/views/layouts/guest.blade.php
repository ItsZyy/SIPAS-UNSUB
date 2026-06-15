<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIPAS UNSUB') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        <link rel="icon" type="image/png" href="{{ asset('logo-title.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col items-center justify-center px-4 bg-gray-50">
            <div class="w-full sm:max-w-md">
                <div class="flex flex-col items-center mb-10">
                    <img src="{{ asset('images/logo/logo-icon.png') }}" alt="SIPAS UNSUB" class="w-28 h-28 mb-5">
                    <h1 class="text-3xl font-extrabold text-indigo-600 tracking-tight">SIPAS UNSUB</h1>
                    <p class="text-sm text-slate-400 mt-1.5">Smart Letter Archiving System</p>
                </div>

                <div class="bg-white rounded-xl shadow-lg px-9 py-9">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
