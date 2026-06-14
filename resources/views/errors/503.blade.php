<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>503 - {{ config('app.name', 'SIPAS UNSUB') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-icon.png') }}">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="min-h-screen flex flex-col items-center justify-center px-4 sm:px-6">
            <div class="flex flex-col items-center text-center max-w-lg mx-auto">
                <div class="w-full max-w-sm sm:max-w-md">
                    <img src="{{ asset('images/error.svg') }}" alt="Error Illustration" class="w-full h-auto">
                </div>

                <div class="mt-8 sm:mt-10">
                    <p class="text-6xl sm:text-7xl font-bold text-gray-200 select-none">503</p>
                    <h1 class="mt-2 text-2xl sm:text-3xl font-bold text-gray-900">
                        Sistem Sedang Dalam Pemeliharaan
                    </h1>
                    <p class="mt-3 text-sm sm:text-base text-gray-500 leading-relaxed">
                        Kami sedang melakukan peningkatan layanan.<br>
                        Silakan kembali beberapa saat lagi.
                    </p>
                </div>

                <div class="mt-8 sm:mt-10">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">
                            Kembali ke Dashboard
                        </a>
                    @else
                        <a href="{{ url('/') }}" class="inline-flex items-center px-6 py-3 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">
                            Kembali ke Beranda
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </body>
</html>
