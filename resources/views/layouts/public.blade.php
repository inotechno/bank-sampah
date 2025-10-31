<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Bank Sampah') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-emerald-900">
        <div class="relative flex min-h-screen flex-col bg-white">
            <div class="absolute inset-x-0 top-0 -z-10 h-64 bg-gradient-to-b from-emerald-200/60 to-transparent blur-3xl"></div>

            <header class="sticky top-0 z-40 border-b border-emerald-100/70 bg-white/90 backdrop-blur">
                <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                    <a href="{{ url('/') }}" class="flex items-center gap-2 text-lg font-semibold text-emerald-700" wire:navigate>
                        <x-application-logo class="h-9 w-auto text-emerald-600" />
                        <span class="hidden sm:block">{{ config('app.name', 'Bank Sampah') }}</span>
                    </a>

                    <nav class="flex items-center gap-4 text-sm font-semibold text-emerald-700">
                        <a href="{{ url('/') }}" class="rounded-lg px-3 py-2 transition hover:bg-emerald-50" wire:navigate>Beranda</a>
                        <a href="#kalkulator" class="rounded-lg px-3 py-2 transition hover:bg-emerald-50">Kalkulator</a>
                        <a href="#tips" class="rounded-lg px-3 py-2 transition hover:bg-emerald-50">Tips</a>
                    </nav>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" wire:navigate class="hidden rounded-xl border border-emerald-200 px-3 py-2 text-sm font-semibold text-emerald-700 transition hover:border-emerald-300 hover:bg-emerald-50 sm:inline-flex">Masuk Admin</a>
                        <a href="{{ route('login') }}" wire:navigate class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4">
                                <path fill-rule="evenodd" d="M3.5 1A1.5 1.5 0 0 0 2 2.5v15A1.5 1.5 0 0 0 3.5 19h7.75a.75.75 0 0 0 0-1.5H3.5a.5.5 0 0 1-.5-.5v-15a.5.5 0 0 1 .5-.5h7.75a.75.75 0 0 0 0-1.5H3.5Zm9 4.25a.75.75 0 0 1 .75-.75h2.5A2.25 2.25 0 0 1 18 6.75v10.5A2.25 2.25 0 0 1 15.75 19h-2.5a.75.75 0 0 1 0-1.5h2.5c.414 0 .75-.336.75-.75V6.75a.75.75 0 0 0-.75-.75h-2.5a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                                <path fill-rule="evenodd" d="M8.47 6.22a.75.75 0 0 1 1.06 0l2.75 2.75a.75.75 0 0 1 0 1.06l-2.75 2.75a.75.75 0 0 1-1.06-1.06l1.47-1.47H6.75a.75.75 0 0 1 0-1.5h3.19L8.47 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                            Panel Admin
                        </a>
                    </div>
                </div>
            </header>

            <main id="kalkulator" class="flex-1">
                {{ $slot }}
            </main>

            <footer id="tips" class="mt-16 border-t border-emerald-100/70 bg-white/90">
                <div class="mx-auto flex w-full max-w-7xl flex-col gap-6 px-4 py-8 text-sm text-emerald-700 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                    <p>© {{ now()->year }} {{ config('app.name', 'Bank Sampah') }}. Semua hak dilindungi.</p>
                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ route('login') }}" wire:navigate class="rounded-lg px-3 py-2 transition hover:bg-emerald-50">Masuk Admin</a>
                        <a href="mailto:info@banksampah.test" class="rounded-lg px-3 py-2 transition hover:bg-emerald-50">Hubungi Kami</a>
                        <span class="hidden rounded-lg px-3 py-2 text-xs uppercase tracking-wide text-emerald-500 sm:inline">Bank Sampah Berkelanjutan</span>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>

