<?php

namespace App\Livewire;

use App\Models\WasteType;
use Livewire\Component;

class Calculator extends Component
{
    public $wasteTypes = [];
    public $selectedWasteTypeId = '';
    public $quantity = null;
    public $total = 0;

    protected $rules = [
        'selectedWasteTypeId' => 'required|exists:waste_types,id',
        'quantity' => 'required|numeric|min:0.1',
    ];

    protected $messages = [
        'selectedWasteTypeId.required' => 'Pilih jenis sampah terlebih dahulu.',
        'selectedWasteTypeId.exists' => 'Jenis sampah yang dipilih tidak valid.',
        'quantity.required' => 'Masukkan jumlah sampah dalam kilogram.',
        'quantity.numeric' => 'Jumlah sampah harus berupa angka.',
        'quantity.min' => 'Jumlah sampah minimal 0.1 kg.',
    ];

    public function mount(): void
    {
        $this->wasteTypes = WasteType::orderBy('name')->get();
    }

    public function updatedSelectedWasteTypeId(): void
    {
        $this->total = 0;
    }

    public function updatedQuantity(): void
    {
        // Reset total when quantity changes to avoid stale values.
        $this->total = 0;
    }

    public function calculateTotal(): void
    {
        $this->validate();

        $wasteType = WasteType::find($this->selectedWasteTypeId);

        if ($wasteType) {
            $this->total = (float) $wasteType->price_per_kg * (float) $this->quantity;
        }
    }

    public function resetCalculator(): void
    {
        $this->reset(['selectedWasteTypeId', 'quantity', 'total']);
        $this->resetErrorBag();
    }

    public function render()
    {
        $selectedWasteType = null;

        if ($this->selectedWasteTypeId) {
            $selectedWasteType = collect($this->wasteTypes)
                ->firstWhere('id', (int) $this->selectedWasteTypeId)
                ?? WasteType::find($this->selectedWasteTypeId);
        }

        return view('livewire.calculator', [
            'selectedWasteType' => $selectedWasteType,
        ])->layout('layouts.app', [
            'title' => 'Kalkulator Bank Sampah',
        ]);
    }
}


