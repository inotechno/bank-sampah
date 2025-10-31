@php
    use Illuminate\Support\Facades\Storage;
@endphp

<div class="py-10">
    <div class="mx-auto flex w-full max-w-8xl flex-col gap-7 px-4 sm:px-7 lg:flex-row lg:px-9">
        <section class="flex-1 rounded-3xl border border-emerald-100 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-emerald-900">Master Jenis Sampah</h1>
                    <p class="text-sm text-emerald-700/80">Kelola daftar jenis sampah, harga per kilogram, dan status ketersediaan untuk pengguna kalkulator.</p>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <div class="relative">
                        <svg class="pointer-events-none absolute left-3 top-1/2 size-4 -translate-y-1/2 text-emerald-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 3.473 9.776l3.125 3.126a.75.75 0 1 0 1.06-1.06l-3.125-3.126A5.5 5.5 0 0 0 9 3.5ZM5.5 9a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0Z" clip-rule="evenodd" />
                        </svg>
                        <input
                            type="search"
                            wire:model.debounce.400ms="search"
                            placeholder="Cari jenis sampah..."
                            class="w-full rounded-xl border border-emerald-200 bg-white pl-9 pr-3 py-2 text-sm text-emerald-900 shadow-inner focus:border-emerald-500 focus:ring-emerald-500"
                        />
                    </div>

                    <button
                        type="button"
                        wire:click="create"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                            <path d="M10 3a1 1 0 0 1 1 1v5h5a1 1 0 1 1 0 2h-5v5a1 1 0 1 1-2 0v-5H4a1 1 0 1 1 0-2h5V4a1 1 0 0 1 1-1Z" />
                        </svg>
                        Jenis baru
                    </button>
                </div>
            </div>

            <div class="mt-6 overflow-hidden rounded-2xl border border-emerald-100">
                <table class="min-w-full divide-y divide-emerald-100 text-sm text-emerald-900">
                    <thead class="bg-emerald-50/80 text-xs uppercase tracking-wide text-emerald-600">
                        <tr>
                            <th class="px-4 py-3 text-left">
                                <button type="button" wire:click="sortBy('name')" class="flex items-center gap-1 font-semibold">
                                    Jenis Sampah
                                    @if ($sortField === 'name')
                                        <svg class="size-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" class="{{ $sortDirection === 'asc' ? 'rotate-180' : '' }} transition" />
                                        </svg>
                                    @endif
                                </button>
                            </th>
                            <th class="px-4 py-3 text-left">
                                <button type="button" wire:click="sortBy('price_per_kg')" class="flex items-center gap-1 font-semibold">
                                    Harga / Kg
                                    @if ($sortField === 'price_per_kg')
                                        <svg class="size-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" class="{{ $sortDirection === 'asc' ? 'rotate-180' : '' }} transition" />
                                        </svg>
                                    @endif
                                </button>
                            </th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-emerald-50 bg-white">
                        @forelse ($wasteTypes as $type)
                            <tr wire:key="type-{{ $type->id }}" class="transition hover:bg-emerald-50/40">
                                <td class="px-4 py-4">
                                    <div class="flex items-start gap-4">
                                        @php
                                            $initial = mb_substr($type->name, 0, 1);
                                        @endphp
                                        <div class="relative">
                                            @if ($type->image_path)
                                                <img src="{{ Storage::url($type->image_path) }}" alt="{{ $type->name }}" class="size-14 rounded-xl object-cover shadow-inner" />
                                            @else
                                                <div class="flex size-14 items-center justify-center rounded-xl bg-emerald-100 text-lg font-semibold text-emerald-700 shadow-inner">{{ $initial }}</div>
                                            @endif
                                        </div>
                                        <div class="space-y-1">
                                            <p class="font-semibold text-emerald-900">{{ $type->name }}</p>
                                            @if ($type->description)
                                                <p class="text-xs text-emerald-600">{{ $type->description }}</p>
                                            @endif
                                            <p class="text-xs text-emerald-500">Slug: {{ $type->slug }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="font-semibold text-emerald-900">Rp{{ number_format($type->price_per_kg, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $type->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                                        <span class="size-2 rounded-full {{ $type->is_active ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                                        {{ $type->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <button
                                            type="button"
                                            wire:click="toggleStatus({{ $type->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="toggleStatus({{ $type->id }})"
                                            class="inline-flex items-center gap-1 rounded-lg border border-emerald-200 px-3 py-1.5 text-xs font-semibold text-emerald-700 transition hover:border-emerald-300 hover:bg-emerald-50"
                                        >
                                            {{ $type->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                        <button
                                            type="button"
                                            wire:click="edit({{ $type->id }})"
                                            class="inline-flex items-center gap-1 rounded-lg border border-emerald-200 px-3 py-1.5 text-xs font-semibold text-emerald-700 transition hover:border-emerald-300 hover:bg-emerald-50"
                                        >
                                            Edit
                                        </button>
                                        <button
                                            type="button"
                                            wire:click="confirmDelete({{ $type->id }})"
                                            class="inline-flex items-center gap-1 rounded-lg border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-600 transition hover:border-red-300 hover:bg-red-50"
                                        >
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-12 text-center text-sm text-emerald-600">
                                    Belum ada jenis sampah yang terdaftar. Tambahkan jenis baru untuk mulai menggunakan kalkulator.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $wasteTypes->links() }}
            </div>
        </section>

        <aside class="w-full max-w-xl rounded-3xl border border-emerald-100 bg-white p-6 shadow-sm lg:sticky lg:top-24">
            <header class="border-b border-emerald-100 pb-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-emerald-500">{{ $editingId ? 'Perbarui' : 'Tambah' }} Jenis Sampah</p>
                <h2 class="mt-1 text-xl font-semibold text-emerald-900">{{ $editingId ? 'Edit Data Jenis Sampah' : 'Buat Jenis Sampah Baru' }}</h2>
                <p class="mt-1 text-sm text-emerald-700/80">Isi informasi lengkap berikut agar kalkulator dapat menampilkan harga yang akurat.</p>
            </header>

            <form wire:submit.prevent="save" class="mt-5 space-y-5">
                <div>
                    <label for="form-name" class="text-sm font-medium text-emerald-900">Nama Jenis Sampah</label>
                    <input
                        id="form-name"
                        type="text"
                        wire:model.live.debounce.400ms="form.name"
                        class="mt-1 block w-full rounded-xl border border-emerald-200 px-4 py-2.5 text-sm text-emerald-900 shadow-inner focus:border-emerald-500 focus:ring-emerald-500"
                        placeholder="Contoh: Plastik PET"
                    />
                    @error('form.name')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="form-price" class="text-sm font-medium text-emerald-900">Harga per Kilogram</label>
                    <div class="mt-1 flex rounded-xl border border-emerald-200 shadow-inner focus-within:border-emerald-500">
                        <span class="flex items-center justify-center rounded-s-xl bg-emerald-50 px-3 text-xs font-semibold uppercase tracking-wide text-emerald-600">Rp</span>
                        <input
                            id="form-price"
                            type="number"
                            min="0"
                            step="100"
                            wire:model.live.debounce.400ms="form.price_per_kg"
                            class="w-full rounded-e-xl border-0 bg-transparent px-3 py-2.5 text-sm text-emerald-900 focus:ring-0"
                            placeholder="3500"
                        />
                    </div>
                    @error('form.price_per_kg')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="form-description" class="text-sm font-medium text-emerald-900">Deskripsi</label>
                    <textarea
                        id="form-description"
                        rows="4"
                        wire:model.live.debounce.400ms="form.description"
                        class="mt-1 block w-full rounded-xl border border-emerald-200 px-4 py-2.5 text-sm text-emerald-900 shadow-inner focus:border-emerald-500 focus:ring-emerald-500"
                        placeholder="Masukkan detail mengenai jenis sampah yang dapat diterima."></textarea>
                    @error('form.description')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="form-image" class="text-sm font-medium text-emerald-900">Foto Jenis Sampah</label>
                    <div class="mt-1 flex flex-col gap-3 rounded-2xl border border-dashed border-emerald-200 bg-emerald-50/40 p-4">
                        <input
                            id="form-image"
                            type="file"
                            accept="image/*"
                            wire:model="image"
                            class="text-sm text-emerald-700"
                        />

                        <div class="flex gap-3">
                            @if ($image)
                                <img src="{{ $image->temporaryUrl() }}" alt="Pratinjau gambar" class="h-24 w-24 rounded-xl object-cover shadow" />
                            @elseif ($currentImage)
                                <img src="{{ Storage::url($currentImage) }}" alt="Pratinjau gambar" class="h-24 w-24 rounded-xl object-cover shadow" />
                            @else
                                <div class="flex h-24 w-24 items-center justify-center rounded-xl border border-emerald-200 text-xs text-emerald-500">Belum ada foto</div>
                            @endif

                            <div class="text-xs text-emerald-600/80">
                                <p>Unggah foto dengan format JPG, PNG, atau WEBP dan ukuran maksimal 2 MB.</p>
                                <p class="mt-1">Foto membantu pengguna mengenali jenis sampah dengan lebih cepat.</p>
                            </div>
                        </div>

                        <div wire:loading.flex wire:target="image" class="items-center gap-2 text-xs font-semibold text-emerald-600">
                            <svg class="size-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                            Mengunggah gambar...
                        </div>
                    </div>
                    @error('image')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3 rounded-xl border border-emerald-100 bg-emerald-50/60 px-4 py-3">
                    <label class="inline-flex items-center gap-3 text-sm font-medium text-emerald-900">
                        <input type="checkbox" wire:model="form.is_active" class="size-4 rounded border-emerald-300 text-emerald-600 focus:ring-emerald-500" />
                        Tampilkan di kalkulator pengguna
                    </label>
                </div>

                <div class="pt-2">
                    <div class="flex flex-col gap-3 sm:flex-row">
                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            wire:target="save, image"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 disabled:opacity-70"
                        >
                            <svg wire:loading wire:target="save" class="size-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                            <span>{{ $editingId ? 'Simpan Perubahan' : 'Simpan Jenis Sampah' }}</span>
                        </button>

                        @if ($editingId)
                            <button
                                type="button"
                                wire:click="cancelEdit"
                                class="inline-flex items-center justify-center gap-2 rounded-xl border border-emerald-200 px-4 py-2.5 text-sm font-semibold text-emerald-700 transition hover:border-emerald-300 hover:bg-emerald-50"
                            >
                                Batalkan
                            </button>
                        @endif
                    </div>
                </div>
            </form>
        </aside>
    </div>
</div>
