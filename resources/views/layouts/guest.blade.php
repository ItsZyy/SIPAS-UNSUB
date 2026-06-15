<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
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

        <script>
            if (localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        </script>
        <script>
            function toggleDarkMode() {
                var html = document.documentElement;
                var isDark = html.classList.toggle('dark');
                localStorage.setItem('darkMode', isDark);
                updateIcons();
            }

            function updateIcons() {
                var isDark = document.documentElement.classList.contains('dark');
                document.querySelectorAll('[id^="sun-icon"]').forEach(function(el) { el.classList.toggle('hidden', !isDark); });
                document.querySelectorAll('[id^="moon-icon"]').forEach(function(el) { el.classList.toggle('hidden', isDark); });
            }

            document.addEventListener('DOMContentLoaded', updateIcons);
        </script>

        <style>
            .anim-logo { opacity: 0; transform: scale(0.8); transition: all 0.7s cubic-bezier(0.22, 1, 0.36, 1); }
            .anim-title { opacity: 0; transform: translateY(10px); transition: all 0.5s cubic-bezier(0.22, 1, 0.36, 1); }
            .anim-tagline { opacity: 0; transition: all 0.5s ease-out; }
            .anim-card { opacity: 0; transform: scale(0.95); transition: all 0.7s cubic-bezier(0.22, 1, 0.36, 1); }
            .anim-reveal { opacity: 1 !important; transform: none !important; }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col items-center justify-center px-4 bg-gray-50 dark:bg-gray-900">
            <div class="w-full sm:max-w-md">
                <div class="flex flex-col items-center mb-10">
                    <img id="anim-logo" src="{{ asset('images/logo/logo-icon.png') }}" alt="SIPAS UNSUB" class="anim-logo w-28 h-28 mb-5 dark:hidden">
                    <img id="anim-logo-dark" src="{{ asset('images/logo/icon-white.png') }}" alt="SIPAS UNSUB" class="anim-logo w-28 h-28 mb-5 hidden dark:block">
                    <h1 id="anim-title" class="anim-title text-3xl font-extrabold text-indigo-600 dark:text-indigo-400 tracking-tight">SIPAS UNSUB</h1>
                    <p id="anim-tagline" class="anim-tagline text-sm text-slate-400 dark:text-gray-400 mt-1.5">Smart Letter Archiving System</p>
                </div>

                <div id="anim-card" class="anim-card bg-white dark:bg-gray-800 rounded-xl shadow-lg dark:shadow-gray-900/50 px-9 py-9 relative">
                    <button id="dark-toggle-login" class="absolute top-3 right-3 p-2 rounded-lg text-gray-400 dark:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" onclick="toggleDarkMode()" aria-label="Toggle dark mode">
                        <svg id="sun-icon-login" class="hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <svg id="moon-icon-login" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>
                    {{ $slot }}
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                requestAnimationFrame(function() {
                    document.querySelectorAll('.anim-logo').forEach(function(el) { el.classList.add('anim-reveal'); });
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
