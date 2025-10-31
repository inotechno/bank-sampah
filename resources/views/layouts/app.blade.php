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
        <div class="relative flex min-h-screen flex-col">
            <div class="pointer-events-none absolute inset-x-0 top-0 -z-10 h-64 bg-gradient-to-b from-emerald-200/80 via-transparent to-transparent blur-3xl"></div>

            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="border-b border-emerald-100/60 bg-white/90 backdrop-blur">
                    <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-1 py-8">
                {{ $slot }}
            </main>

            <footer class="border-t border-emerald-100/60 bg-white/90">
                <div class="mx-auto flex w-full max-w-7xl flex-col gap-4 px-4 py-6 text-sm text-emerald-700 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                    <p>© {{ now()->year }} {{ config('app.name', 'Bank Sampah') }}. Mendukung gerakan lingkungan bersih dan ekonomi sirkular.</p>
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="rounded-lg bg-emerald-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-emerald-600">Bank Sampah Digital</span>
                        <a href="{{ route('home') }}" wire:navigate class="rounded-lg px-3 py-1 transition hover:bg-emerald-50">Kalkulator</a>
                        <a href="mailto:info@banksampah.test" class="rounded-lg px-3 py-1 transition hover:bg-emerald-50">Dukungan</a>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
