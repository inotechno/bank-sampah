<?php

namespace App\Livewire\Admin;

use App\Models\WasteType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class WasteTypeManager extends Component
{
    use WithFileUploads;
    use WithPagination;

    public string $search = '';

    public string $sortField = 'name';

    public string $sortDirection = 'asc';

    public ?int $editingId = null;

    public bool $showForm = true;

    /**
     * @var array{name: string, description: string|null, price_per_kg: string|float, is_active: bool}
     */
    public array $form = [
        'name' => '',
        'description' => '',
        'price_per_kg' => '',
        'is_active' => true,
    ];

    /**
     * @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile|null
     */
    public $image = null;

    public ?string $currentImage = null;

    protected array $queryString = [
        'search' => ['except' => ''],
    ];

    protected string $paginationTheme = 'tailwind';

    public function updatedSearch(): void
    {
        $this->search = trim($this->search);
        $this->resetPage();
    }

    public function updated($field): void
    {
        if (str_starts_with($field, 'form.')) {
            $this->validateOnly($field);
        }
    }

    public function updatedImage(): void
    {
        $this->validateOnly('image');
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $type = WasteType::findOrFail($id);

        $this->editingId = $type->id;
        $this->form = [
            'name' => $type->name,
            'description' => $type->description ?? '',
            'price_per_kg' => number_format((float) $type->price_per_kg, 2, '.', ''),
            'is_active' => (bool) $type->is_active,
        ];
        $this->currentImage = $type->image_path;
        $this->image = null;
        $this->showForm = true;
    }

    public function cancelEdit(): void
    {
        $this->resetForm();
    }

    public function save(): void
    {
        $this->validate();

        $payload = [
            'name' => $this->form['name'],
            'slug' => $this->generateUniqueSlug($this->form['name'], $this->editingId),
            'description' => $this->form['description'] ? (string) $this->form['description'] : null,
            'price_per_kg' => round((float) $this->form['price_per_kg'], 2),
            'is_active' => (bool) $this->form['is_active'],
        ];

        if ($this->image) {
            $path = $this->image->store('waste-types', 'public');
            $payload['image_path'] = $path;

            if ($this->currentImage && Storage::disk('public')->exists($this->currentImage)) {
                Storage::disk('public')->delete($this->currentImage);
            }

            $this->currentImage = $path;
        }

        if ($this->editingId) {
            $type = WasteType::findOrFail($this->editingId);

            if (! array_key_exists('image_path', $payload)) {
                $payload['image_path'] = $type->image_path;
            }

            $type->update($payload);

            LivewireAlert::title('Jenis sampah diperbarui!')
                ->success()
                ->toast()
                ->timer(2500)
                ->show();
        } else {
            $type = WasteType::create($payload);
            $this->editingId = $type->id;

            LivewireAlert::title('Jenis sampah ditambahkan!')
                ->success()
                ->toast()
                ->timer(2500)
                ->show();
        }

        $this->resetForm();
    }

    public function confirmDelete(int $id): void
    {
        $type = WasteType::findOrFail($id);

        LivewireAlert::title('Hapus jenis sampah?')
            ->text($type->name.' akan dihapus secara permanen.')
            ->asConfirm()
            ->confirmButtonText('Ya, hapus')
            ->confirmButtonColor('#dc2626')
            ->withDenyButton('Batal')
            ->onConfirm('deleteWasteType', ['id' => $id])
            ->show();
    }

    /**
     * @param  array{id:int}  $data
     */
    public function deleteWasteType(array $data): void
    {
        $type = WasteType::findOrFail($data['id']);

        if ($type->image_path && Storage::disk('public')->exists($type->image_path)) {
            Storage::disk('public')->delete($type->image_path);
        }

        $type->delete();

        LivewireAlert::title('Jenis sampah dihapus!')
            ->success()
            ->toast()
            ->timer(2500)
            ->show();

        $this->resetForm();
    }

    public function toggleStatus(int $id): void
    {
        $type = WasteType::findOrFail($id);
        $type->update(['is_active' => ! $type->is_active]);

        LivewireAlert::title('Status berhasil diperbarui!')
            ->success()
            ->toast()
            ->timer(2000)
            ->show();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    protected function resetForm(): void
    {
        $this->form = [
            'name' => '',
            'description' => '',
            'price_per_kg' => '',
            'is_active' => true,
        ];

        $this->editingId = null;
        $this->currentImage = null;
        $this->image = null;
        $this->showForm = true;
        $this->resetValidation();
    }

    protected function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        while (
            WasteType::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn (Builder $query) => $query->whereKeyNot($ignoreId))
                ->exists()
        ) {
            $slug = sprintf('%s-%d', $baseSlug, $counter);
            $counter++;
        }

        return $slug;
    }

    protected function rules(): array
    {
        $imageRule = $this->editingId ? 'nullable' : 'required';

        return [
            'form.name' => ['required', 'string', 'max:255'],
            'form.description' => ['nullable', 'string', 'max:2000'],
            'form.price_per_kg' => ['required', 'numeric', 'min:100'],
            'form.is_active' => ['boolean'],
            'image' => [$imageRule, 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function render()
    {
        $wasteTypes = WasteType::query()
            ->when($this->search, function (Builder $query): void {
                $term = '%'.$this->search.'%';

                $query->where(function (Builder $builder) use ($term): void {
                    $builder->where('name', 'like', $term)
                        ->orWhere('description', 'like', $term);
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(8);

        return view('livewire.admin.waste-type-manager', [
            'wasteTypes' => $wasteTypes,
        ]);
    }
}
