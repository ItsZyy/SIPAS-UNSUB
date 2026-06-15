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

        <style>
            .anim-logo { opacity: 0; transform: scale(0.8); transition: all 0.7s cubic-bezier(0.22, 1, 0.36, 1); }
            .anim-title { opacity: 0; transform: translateY(10px); transition: all 0.5s cubic-bezier(0.22, 1, 0.36, 1); }
            .anim-tagline { opacity: 0; transition: all 0.5s ease-out; }
            .anim-card { opacity: 0; transform: scale(0.95); transition: all 0.7s cubic-bezier(0.22, 1, 0.36, 1); }
            .anim-reveal { opacity: 1 !important; transform: none !important; }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col items-center justify-center px-4 bg-gray-50">
            <div class="w-full sm:max-w-md">
                <div class="flex flex-col items-center mb-10">
                    <img id="anim-logo" src="{{ asset('images/logo/logo-icon.png') }}" alt="SIPAS UNSUB" class="anim-logo w-28 h-28 mb-5">
                    <h1 id="anim-title" class="anim-title text-3xl font-extrabold text-indigo-600 tracking-tight">SIPAS UNSUB</h1>
                    <p id="anim-tagline" class="anim-tagline text-sm text-slate-400 mt-1.5">Smart Letter Archiving System</p>
                </div>

                <div id="anim-card" class="anim-card bg-white rounded-xl shadow-lg px-9 py-9">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                requestAnimationFrame(function() {
                    document.getElementById('anim-logo').classList.add('anim-reveal');
                    setTimeout(function() {
                        document.getElementById('anim-title').classList.add('anim-reveal');
                    }, 150);
                    setTimeout(function() {
                        document.getElementById('anim-tagline').classList.add('anim-reveal');
                    }, 350);
                    setTimeout(function() {
                        document.getElementById('anim-card').classList.add('anim-reveal');
                    }, 550);
                });
            });
        </script>
    </body>
</html>
