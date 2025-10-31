<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Bank Sampah') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-emerald-50 text-emerald-900">
        <div class="relative flex min-h-screen flex-col items-center justify-center px-4 py-8 sm:px-6 lg:px-8">
            <div class="pointer-events-none absolute inset-x-0 top-0 -z-10 h-64 bg-gradient-to-b from-emerald-200/80 via-transparent to-transparent blur-3xl"></div>

            <div class="mb-8 text-center">
                <a href="/" wire:navigate class="inline-flex items-center justify-center gap-3">
                    <x-application-logo class="h-14 w-auto text-emerald-600" />
                    <span class="text-xl font-semibold text-emerald-700">{{ config('app.name', 'Bank Sampah') }}</span>
                </a>
                <p class="mt-2 text-sm text-emerald-600/80">Kelola bank sampah Anda dan bantu warga menghitung nilai setoran secara akurat.</p>
            </div>

            <div class="w-full max-w-md rounded-3xl border border-emerald-100 bg-white/95 p-8 shadow-xl backdrop-blur">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
