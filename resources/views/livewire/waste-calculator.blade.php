<div class="relative isolate overflow-hidden bg-gradient-to-br from-emerald-50 via-white to-white py-16 sm:py-24">
    <div class="absolute inset-x-0 top-0 -z-10 h-64 bg-gradient-to-b from-emerald-100/80 to-transparent blur-3xl"></div>

    <div class="mx-auto flex w-full max-w-7xl flex-col gap-12 px-4 sm:px-6 lg:flex-row lg:px-8">
        <section class="flex-1 rounded-3xl border border-emerald-100 bg-white/80 p-6 shadow-xl backdrop-blur">
            <header class="space-y-3 border-b border-emerald-50 pb-6">
                <span
                    class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium uppercase text-emerald-700">
                    <span class="size-2 rounded-full bg-emerald-500"></span>
                    Kalkulator Bank Sampah
                </span>
                <h1 class="text-3xl font-bold text-emerald-900 sm:text-4xl">Hitung Nilai Setoran Sampah Anda</h1>
                <p class="text-sm text-emerald-800/80">
                    Pilih jenis sampah, masukkan beratnya, dan dapatkan estimasi nilai uang yang akan Anda terima.
                    Nilai ini bersifat perkiraan berdasarkan harga per kilogram yang telah ditetapkan oleh pengelola
                    bank sampah.
                </p>
            </header>

            <div class="mt-8 space-y-6">
                @forelse ($entries as $index => $entry)
                    <article wire:key="entry-{{ $index }}" class="rounded-3xl border border-emerald-100 bg-white/95 p-6 shadow-sm ring-1 ring-transparent transition hover:shadow-lg hover:ring-emerald-200">
                        <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                            <div class="relative shrink-0">
                                @if ($entry['waste_type_id'] && ($preview = $wasteTypes->firstWhere('id', $entry['waste_type_id'])))
                                    @if ($preview->image_path)
                                        <img src="{{ Storage::url($preview->image_path) }}" alt="{{ $preview->name }}" class="size-12 rounded-xl object-cover shadow-inner" />
                                    @else
                                        <div class="flex size-12 items-center justify-center rounded-xl bg-emerald-100 text-lg font-semibold text-emerald-700 shadow-inner">
                                            {{ mb_strtoupper(mb_substr($preview->name, 0, 1)) }}
                                        </div>
                                    @endif
                                @else
                                    <div class="flex size-12 items-center justify-center rounded-xl bg-emerald-50 text-lg font-semibold text-emerald-400 shadow-inner">
                                        ?
                                    </div>
                                @endif
                            </div>

                            <div class="grid flex-1 gap-3 sm:grid-cols-2">
                                <div class="space-y-2 sm:col-span-1">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-emerald-500">Jenis Sampah</p>
                                    <select
                                        id="waste-type-{{ $index }}"
                                        wire:model.live="entries.{{ $index }}.waste_type_id"
                                        class="w-full mt-2 rounded-2xl border border-emerald-200 bg-white px-4 py-3 text-sm font-semibold text-emerald-900 shadow-inner focus:border-emerald-500 focus:ring-emerald-500"
                                    >
                                        <option value="">Pilih jenis sampah</option>
                                        @foreach ($wasteTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }} — Rp{{ number_format($type->price_per_kg, 0, ',', '.') }}/kg</option>
                                        @endforeach
                                    </select>
                                    @error('entries.'.$index.'.waste_type_id')
                                        <p class="text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2 sm:col-span-1">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-emerald-500">Berat Sampah</p>
                                    <div class="flex items-center gap-2 mt-2 rounded-2xl border border-emerald-200 bg-white px-3 py-1 shadow-inner focus-within:border-emerald-500">
                                        <input
                                            id="weight-{{ $index }}"
                                            type="number"
                                            min="0"
                                            step="0.1"
                                            wire:model.live="entries.{{ $index }}.weight"
                                            class="w-full border-0 bg-transparent text-center text-sm font-semibold text-emerald-900 focus:ring-0"
                                            placeholder="0,0"
                                        />
                                        <span class="text-xs font-semibold uppercase tracking-wide text-emerald-500">kg</span>
                                    </div>
                                    @error('entries.'.$index.'.weight')
                                        <p class="text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <button
                                type="button"
                                wire:click="removeEntry({{ $index }})"
                                class="inline-flex items-center justify-center gap-2 self-start rounded-2xl border border-red-100 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 transition hover:border-red-200 hover:bg-red-100 disabled:cursor-not-allowed disabled:border-gray-100 disabled:bg-gray-50 disabled:text-gray-400"
                                @disabled(count($entries) <= 1)
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4">
                                    <path fill-rule="evenodd" d="M5.5 5A1.5 1.5 0 0 0 4 6.5v9A1.5 1.5 0 0 0 5.5 17h9a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 5h-9ZM8 8a.75.75 0 0 1 .75.75V13a.75.75 0 0 1-1.5 0V8.75A.75.75 0 0 1 8 8Zm3.25 0a.75.75 0 0 1 .75.75V13a.75.75 0 0 1-1.5 0V8.75A.75.75 0 0 1 11.25 8ZM7 3.5A1.5 1.5 0 0 1 8.5 2h3A1.5 1.5 0 0 1 13 3.5v.5h2.5a.75.75 0 0 1 0 1.5h-11a.75.75 0 0 1 0-1.5H7v-.5Z" clip-rule="evenodd" />
                                </svg>
                                Hapus
                            </button>

                        @if ($selectedType = $wasteTypes->firstWhere('id', $entry['waste_type_id'] ?? null))
                            <div class="mt-6 space-y-4">
                                <dl class="grid gap-4 sm:grid-cols-2">
                                    <div class="rounded-2xl border border-emerald-100 bg-emerald-50/70 px-4 py-3">
                                        <dt class="text-xs font-semibold uppercase tracking-wide text-emerald-500">Harga per kilogram</dt>
                                        <dd class="mt-1 text-lg font-semibold text-emerald-900">Rp{{ number_format($selectedType->price_per_kg, 0, ',', '.') }}</dd>
                                    </div>
                                    <div class="rounded-2xl border border-emerald-100 bg-emerald-50/70 px-4 py-3">
                                        <dt class="text-xs font-semibold uppercase tracking-wide text-emerald-500">Subtotal</dt>
                                        <dd class="mt-1 text-lg font-semibold text-emerald-900">
                                            @if(! empty($entry['weight']))
                                                Rp{{ number_format($selectedType->price_per_kg * (float) $entry['weight'], 0, ',', '.') }}
                                            @else
                                                —
                                            @endif
                                        </dd>
                                    </div>
                                </dl>

                                @if ($selectedType->description)
                                    <p class="rounded-2xl border border-emerald-100 bg-white px-4 py-3 text-xs text-emerald-700">
                                        {{ $selectedType->description }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </article>
                @empty
                    <p
                        class="rounded-2xl border border-dashed border-emerald-200 bg-white/80 p-6 text-center text-sm text-emerald-700">
                        Belum ada jenis sampah yang dimasukkan.</p>
                @endforelse
            </div>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <button type="button" wire:click="addEntry"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-emerald-200 bg-white px-4 py-2.5 text-sm font-semibold text-emerald-700 transition hover:border-emerald-300 hover:bg-emerald-50">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path
                            d="M10 3a1 1 0 0 1 1 1v5h5a1 1 0 1 1 0 2h-5v5a1 1 0 1 1-2 0v-5H4a1 1 0 1 1 0-2h5V4a1 1 0 0 1 1-1Z" />
                    </svg>
                    Tambah Jenis Sampah
                </button>

                <button type="button" wire:click="calculate"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-xl shadow-emerald-500/30 transition hover:bg-emerald-700">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                        <path
                            d="M12 2a1 1 0 0 1 .911.59l8 18a1 1 0 0 1-1.822.82L16.382 16H7.618l-2.707 5.41a1 1 0 0 1-1.822-.82l8-18A1 1 0 0 1 12 2Zm3.382 12-3.382-6.764L8.618 14h6.764Z" />
                    </svg>
                    Hitung Total
                </button>
            </div>

            <footer class="mt-8 rounded-2xl border border-emerald-100 bg-emerald-50/80 p-6">
                <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-emerald-500">Estimasi Total</p>
                        <p class="mt-1 text-3xl font-bold text-emerald-900">
                            Rp{{ number_format($summary['total'], 0, ',', '.') }}</p>
                    </div>
                    <div class="text-sm text-emerald-700/80">
                        Estimasi nilai setoran ini akan dikonfirmasi kembali oleh petugas setelah proses penimbangan di
                        lokasi bank sampah.
                    </div>
                </div>
            </footer>
        </section>

        <aside class="w-full max-w-xl space-y-6">
            <div class="rounded-3xl border border-emerald-100 bg-white/90 p-6 shadow-lg">
                <h2 class="text-lg font-semibold text-emerald-900">Ringkasan Setoran</h2>
                <p class="mt-2 text-sm text-emerald-700/80">Pantau perincian setiap jenis sampah untuk memastikan
                    hitungan sesuai dengan berat yang Anda masukkan.</p>

                <ul class="mt-6 space-y-4">
                    @forelse ($summary['rows'] as $row)
                        <li class="rounded-2xl border border-emerald-100 bg-emerald-50/80 px-4 py-3">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-sm font-semibold text-emerald-900">{{ $row['name'] }}</p>
                                    <p class="text-xs text-emerald-600">{{ number_format($row['weight'], 1, ',', '.') }} kg
                                        × Rp{{ number_format($row['price'], 0, ',', '.') }}</p>
                                </div>
                                <p class="text-sm font-bold text-emerald-900">
                                    Rp{{ number_format($row['total'], 0, ',', '.') }}</p>
                            </div>
                            @if (!empty($row['description']))
                                <p class="mt-2 text-xs text-emerald-700/80">{{ $row['description'] }}</p>
                            @endif
                        </li>
                    @empty
                        <li
                            class="rounded-2xl border border-dashed border-emerald-200 bg-white/70 px-4 py-6 text-center text-sm text-emerald-700/70">
                            Data ringkasan akan muncul setelah Anda memilih jenis sampah dan memasukkan beratnya.
                        </li>
                    @endforelse
                </ul>

                <div
                    class="mt-6 flex items-center justify-between rounded-2xl border border-emerald-200 bg-white px-4 py-3">
                    <p class="text-sm font-semibold text-emerald-900">Perkiraan Total</p>
                    <p class="text-xl font-bold text-emerald-600">Rp{{ number_format($summary['total'], 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="rounded-3xl border border-emerald-100 bg-white/90 p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-emerald-900">Rekomendasi Jenis Sampah</h2>
                    <span class="text-xs font-semibold uppercase tracking-wide text-emerald-500">Top Harga</span>
                </div>
                <p class="mt-2 text-sm text-emerald-700/80">Jenis-jenis berikut memiliki harga per kilogram tertinggi
                    dan belum Anda tambahkan.</p>

                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    @forelse ($recommendations as $type)
                        <button type="button" wire:click="quickAdd({{ $type->id }})"
                            class="group flex flex-col items-start gap-2 rounded-2xl border border-emerald-100 bg-emerald-50/70 px-4 py-3 text-left transition hover:border-emerald-200 hover:bg-emerald-100">
                            <div>
                                <p class="text-sm font-semibold text-emerald-900 group-hover:text-emerald-700">
                                    {{ $type->name }}</p>
                                <p class="text-xs text-emerald-600">
                                    Rp{{ number_format($type->price_per_kg, 0, ',', '.') }}/kg</p>
                            </div>
                            <span
                                class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 group-hover:text-emerald-700">
                                Tambahkan ke kalkulator
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="size-4">
                                    <path
                                        d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                </svg>
                            </span>
                        </button>
                    @empty
                        <p
                            class="rounded-2xl border border-dashed border-emerald-200 bg-white/70 px-4 py-6 text-center text-sm text-emerald-700/70">
                            Semua jenis sampah dengan nilai terbaik telah Anda masukkan.
                        </p>
                    @endforelse
                </div>
            </div>

            <div
                class="rounded-3xl border border-emerald-100 bg-gradient-to-br from-emerald-500 via-emerald-600 to-emerald-700 p-6 text-white shadow-xl">
                <h2 class="text-lg font-semibold">Tips Maksimalkan Setoran</h2>
                <ul class="mt-4 space-y-3 text-sm">
                    <li class="flex items-start gap-3">
                        <span
                            class="mt-1 inline-flex size-6 items-center justify-center rounded-full border border-white/30 bg-white/10 text-xs font-bold">1</span>
                        <span>Pisahkan sampah berdasarkan jenisnya untuk mempercepat proses penimbangan.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span
                            class="mt-1 inline-flex size-6 items-center justify-center rounded-full border border-white/30 bg-white/10 text-xs font-bold">2</span>
                        <span>Pastikan sampah dalam keadaan bersih dan kering agar harga tetap optimal.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span
                            class="mt-1 inline-flex size-6 items-center justify-center rounded-full border border-white/30 bg-white/10 text-xs font-bold">3</span>
                        <span>Gunakan fitur rekomendasi untuk melihat jenis sampah dengan nilai jual tertinggi saat
                            ini.</span>
                    </li>
                </ul>
            </div>
        </aside>
    </div>

    <div class="mt-16 text-center text-xs text-emerald-700/70">
        Data harga per kilogram mengacu pada pengaturan admin dan dapat berubah sewaktu-waktu.
    </div>
</div>