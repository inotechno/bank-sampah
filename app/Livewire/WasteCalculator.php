<?php

namespace App\Livewire;

use App\Models\WasteType;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class WasteCalculator extends Component
{
    /**
     * @var array<int, array{waste_type_id: int|null, weight: float|null}>
     */
    public array $entries = [];

    /**
     * @var Collection<int, WasteType>
     */
    public Collection $wasteTypes;

    public function mount(): void
    {
        $this->wasteTypes = WasteType::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'description', 'price_per_kg', 'image_path']);

        $firstId = $this->wasteTypes->first()?->id;

        $this->entries = [[
            'waste_type_id' => $firstId,
            'weight' => $firstId ? 1.0 : null,
        ]];
    }

    public function addEntry(): void
    {
        $this->entries[] = [
            'waste_type_id' => null,
            'weight' => null,
        ];
    }

    public function removeEntry(int $index): void
    {
        if (count($this->entries) <= 1) {
            return;
        }

        unset($this->entries[$index]);
        $this->entries = array_values($this->entries);
    }

    public function updatedEntries($value, string $key): void
    {
        $field = "entries.$key";

        if (str_ends_with($key, 'weight') && $value !== null && $value !== '') {
            [$rowIndex] = explode('.', $key, 2);
            $this->entries[(int) $rowIndex]['weight'] = (float) $value;
        }

        $this->validateOnly($field);
    }

    public function calculate(): void
    {
        $this->validate();
    }

    public function quickAdd(int $wasteTypeId): void
    {
        if (! $this->wasteTypes->firstWhere('id', $wasteTypeId)) {
            return;
        }

        foreach ($this->entries as $index => $entry) {
            if (! $entry['waste_type_id']) {
                $this->entries[$index]['waste_type_id'] = $wasteTypeId;
                $this->entries[$index]['weight'] = $entry['weight'] ?? 1.0;

                $this->calculate();

                return;
            }
        }

        $this->entries[] = [
            'waste_type_id' => $wasteTypeId,
            'weight' => 1.0,
        ];

        $this->calculate();
    }

    protected function rules(): array
    {
        $ids = $this->wasteTypes->pluck('id')->all();

        return [
            'entries' => ['required', 'array', 'min:1'],
            'entries.*.waste_type_id' => ['required', Rule::in($ids)],
            'entries.*.weight' => ['required', 'numeric', 'min:0.1', 'max:1000'],
        ];
    }

    protected function messages(): array
    {
        return [
            'entries.*.waste_type_id.required' => 'Silakan pilih jenis sampah.',
            'entries.*.waste_type_id.in' => 'Jenis sampah tidak valid.',
            'entries.*.weight.required' => 'Masukkan berat sampah.',
            'entries.*.weight.numeric' => 'Berat harus berupa angka.',
            'entries.*.weight.min' => 'Berat minimal :min kg.',
            'entries.*.weight.max' => 'Berat maksimal :max kg.',
        ];
    }

    public function getSummaryProperty(): array
    {
        $rows = collect($this->entries)->map(function (array $entry) {
            $wasteType = $this->wasteTypes->firstWhere('id', $entry['waste_type_id']);

            if (! $wasteType || empty($entry['weight']) || $entry['weight'] <= 0) {
                return null;
            }

            $weight = (float) $entry['weight'];
            $total = (float) $wasteType->price_per_kg * $weight;

            return [
                'name' => $wasteType->name,
                'description' => $wasteType->description,
                'weight' => $weight,
                'price' => (float) $wasteType->price_per_kg,
                'total' => $total,
            ];
        })->filter()->values();

        return [
            'rows' => $rows,
            'total' => $rows->sum('total'),
        ];
    }

    public function getRecommendationsProperty(): Collection
    {
        $selected = collect($this->entries)
            ->pluck('waste_type_id')
            ->filter()
            ->unique();

        return $this->wasteTypes
            ->reject(fn (WasteType $type) => $selected->contains($type->id))
            ->sortByDesc('price_per_kg')
            ->take(3)
            ->values();
    }

    public function render()
    {
        return view('livewire.waste-calculator', [
            'entries' => $this->entries,
            'wasteTypes' => $this->wasteTypes,
            'summary' => $this->summary,
            'recommendations' => $this->recommendations,
        ]);
    }
}

