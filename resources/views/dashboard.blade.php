<x-app-layout>
    <x-slot name="header">
        <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <div>
                <h2 class="text-2xl font-semibold text-emerald-900">{{ __('Dashboard') }}</h2>
                <p class="text-sm text-emerald-600/80">Ringkasan singkat aktivitas bank sampah Anda.</p>
            </div>
            @if (auth()->user()->is_admin)
                <a href="{{ route('admin.waste-types') }}" wire:navigate class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700">
                    Kelola Jenis Sampah
                </a>
            @endif
        </div>
    </x-slot>
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-6 lg:grid-cols-3">
            <article class="rounded-3xl border border-emerald-100 bg-white p-6 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-emerald-500">Total Jenis Sampah</p>
                <p class="mt-3 text-4xl font-bold text-emerald-900">{{ $totalWasteTypes }}</p>
                <p class="mt-2 text-sm text-emerald-600/80">Jumlah keseluruhan jenis sampah yang tersedia untuk pengguna kalkulator.</p>
            </article>

            <article class="rounded-3xl border border-emerald-100 bg-white p-6 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-emerald-500">Jenis Aktif</p>
                <p class="mt-3 text-4xl font-bold text-emerald-900">{{ $activeWasteTypes }}</p>
                <p class="mt-2 text-sm text-emerald-600/80">Jenis yang dapat dipilih oleh masyarakat saat melakukan estimasi setoran.</p>
            </article>

            <article class="rounded-3xl border border-emerald-100 bg-white p-6 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-emerald-500">Rata-rata Harga per Kg</p>
                <p class="mt-3 text-4xl font-bold text-emerald-900">Rp{{ $averagePrice ? number_format($averagePrice, 0, ',', '.') : '0' }}</p>
                <p class="mt-2 text-sm text-emerald-600/80">Sebagai gambaran rata-rata nilai yang diterima warga dari seluruh jenis sampah.</p>
            </article>
        </div>

        <div class="mt-10 rounded-3xl border border-emerald-100 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-emerald-900">Selamat datang, {{ auth()->user()->name }}!</h3>
            <p class="mt-2 text-sm text-emerald-700/80">
                Gunakan menu di atas untuk memperbarui daftar jenis sampah, mengatur harga per kilogram, dan memastikan kalkulator selalu memberikan informasi terbaru kepada masyarakat.
            </p>
            <ul class="mt-4 grid gap-3 text-sm text-emerald-700/80 sm:grid-cols-2">
                <li class="flex items-start gap-3">
                    <span class="mt-1 inline-flex size-6 items-center justify-center rounded-full bg-emerald-100 text-xs font-bold text-emerald-600">1</span>
                    Perbarui harga secara berkala agar nilai estimasi tetap akurat.
                </li>
                <li class="flex items-start gap-3">
                    <span class="mt-1 inline-flex size-6 items-center justify-center rounded-full bg-emerald-100 text-xs font-bold text-emerald-600">2</span>
                    Aktifkan atau nonaktifkan jenis sampah sesuai dengan ketersediaan layanan.
                </li>
            </ul>
        </div>
    </div>
</x-app-layout>
