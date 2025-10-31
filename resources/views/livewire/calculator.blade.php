<div class="max-w-3xl mx-auto py-10 px-4 md:px-0">
    <div class="text-center md:text-left">
        <h1 class="text-3xl font-semibold text-slate-800">Kalkulator Bank Sampah</h1>
        <p class="mt-2 text-slate-600">Hitung estimasi uang yang Anda terima berdasarkan jenis dan berat sampah yang disetor.</p>
    </div>

    <div class="mt-8 bg-white border border-slate-200 rounded-xl shadow-sm">
        <form wire:submit.prevent="calculateTotal" class="p-6 space-y-6">
            <div>
                <label class="block text-sm font-medium text-slate-700">Jenis Sampah</label>
                <select
                    wire:model.live="selectedWasteTypeId"
                    class="mt-1 w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"
                >
                    <option value="">-- Pilih jenis sampah --</option>
                    @foreach ($wasteTypes as $wasteType)
                        <option value="{{ $wasteType->id }}">{{ $wasteType->name }} - Rp {{ number_format($wasteType->price_per_kg, 0, ',', '.') }}/kg</option>
                    @endforeach
                </select>
                @error('selectedWasteTypeId')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Jumlah Sampah (kg)</label>
                <input
                    type="number"
                    step="0.01"
                    min="0"
                    wire:model.live="quantity"
                    class="mt-1 w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"
                    placeholder="Masukkan berat sampah"
                >
                @error('quantity')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @if ($selectedWasteType)
                <div class="rounded-lg bg-slate-50 border border-slate-200 p-4 flex items-start gap-4">
                    @if ($selectedWasteType->photo)
                        <img
                            src="{{ asset('storage/' . $selectedWasteType->photo) }}"
                            alt="Foto {{ $selectedWasteType->name }}"
                            class="h-20 w-20 rounded-lg object-cover border border-slate-200"
                        >
                    @endif
                    <div>
                        <p class="font-semibold text-slate-800">{{ $selectedWasteType->name }}</p>
                        <p class="text-sm text-slate-600 mt-1">Harga per kilogram: <span class="font-semibold">Rp {{ number_format($selectedWasteType->price_per_kg, 0, ',', '.') }}</span></p>
                        @if ($selectedWasteType->description)
                            <p class="text-sm text-slate-500 mt-2">{{ $selectedWasteType->description }}</p>
                        @endif
                    </div>
                </div>
            @endif

            <div class="flex flex-col md:flex-row gap-3">
                <button type="submit" class="inline-flex justify-center rounded-lg bg-emerald-600 px-4 py-2 text-white font-semibold hover:bg-emerald-700">Hitung Total</button>
                <button type="button" wire:click="resetCalculator" class="inline-flex justify-center rounded-lg border border-slate-300 px-4 py-2 font-semibold text-slate-700 hover:bg-slate-100">Reset</button>
            </div>
        </form>

        @if ($total > 0)
            <div class="border-t border-slate-200 bg-slate-50 p-6">
                <p class="text-sm text-slate-600">Perkiraan total yang akan diterima:</p>
                <p class="mt-2 text-4xl font-bold text-emerald-600">Rp {{ number_format($total, 0, ',', '.') }}</p>
            </div>
        @endif
    </div>

    <div class="mt-6 text-sm text-slate-500">
        <p>Kalkulator ini bersifat estimasi. Harga akhir dapat berbeda sesuai kebijakan bank sampah.</p>
    </div>
</div>

