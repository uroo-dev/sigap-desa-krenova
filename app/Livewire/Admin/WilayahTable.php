<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\WithSigapAlerts;
use App\Models\Wilayah;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;

class WilayahTable extends Component
{
    use WithSigapAlerts;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'tipe')]
    public string $tipeFilter = '';

    public bool $showFormModal = false;

    public bool $showDeleteModal = false;

    public ?int $editingId = null;

    public ?int $deleteId = null;

    public string $deleteName = '';

    public string $tipe = 'rt';

    public string $nama = '';

    public string $parent_id = '';

    public string $kode = '';

    public string $geojson = '';

    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->showFormModal = true;
    }

    public function openEditModal(int $id): void
    {
        $this->resetValidation();
        $item = Wilayah::findOrFail($id);

        $this->editingId = $item->id;
        $this->tipe = $item->tipe;
        $this->nama = $item->nama;
        $this->parent_id = $item->parent_id ? (string) $item->parent_id : '';
        $this->kode = $item->kode ?? '';
        $this->geojson = $item->geojson
            ? (string) json_encode($item->geojson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
            : '';
        $this->showFormModal = true;
    }

    public function save(): void
    {
        $validated = $this->validate([
            'tipe' => ['required', 'in:desa,dusun,rw,rt'],
            'nama' => ['required', 'string', 'max:100'],
            'parent_id' => array_filter([
                'nullable',
                'exists:wilayah,id',
                $this->editingId ? Rule::notIn([$this->editingId]) : null,
            ]),
            'kode' => ['nullable', 'string', 'max:32', Rule::unique('wilayah', 'kode')->ignore($this->editingId)],
            'geojson' => ['nullable', 'json'],
        ]);

        $payload = [
            'tipe' => $validated['tipe'],
            'nama' => $validated['nama'],
            'parent_id' => $validated['parent_id'] !== '' ? (int) $validated['parent_id'] : null,
            'kode' => $validated['kode'] !== '' ? $validated['kode'] : null,
            'geojson' => ! empty($validated['geojson']) ? json_decode($validated['geojson'], true) : null,
        ];

        if ($this->editingId) {
            $wilayah = Wilayah::findOrFail($this->editingId);
            $wilayah->update($payload);
            $this->closeModals();
            $this->toastSuccess("Wilayah {$wilayah->nama} berhasil diperbarui.");

            return;
        }

        $wilayah = Wilayah::create($payload);
        $this->closeModals();
        $this->toastSuccess("Wilayah {$wilayah->nama} berhasil ditambahkan.");
    }

    public function confirmDelete(int $id): void
    {
        $item = Wilayah::findOrFail($id);
        $this->deleteId = $item->id;
        $this->deleteName = $item->nama;
        $this->showDeleteModal = true;
    }

    public function deleteConfirmed(): void
    {
        if ($this->deleteId === null) {
            return;
        }

        try {
            $item = Wilayah::findOrFail($this->deleteId);
            $nama = $item->nama;
            $item->delete();
            $this->closeModals();
            $this->toastSuccess("Wilayah {$nama} berhasil dihapus.");
        } catch (\Throwable $e) {
            $this->closeModals();
            $this->toastError('Wilayah tidak dapat dihapus karena masih digunakan oleh data warga, laporan, atau surat.');
        }
    }

    public function closeModals(): void
    {
        $this->showFormModal = false;
        $this->showDeleteModal = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->resetValidation();
        $this->editingId = null;
        $this->deleteId = null;
        $this->deleteName = '';
        $this->tipe = 'rt';
        $this->nama = '';
        $this->parent_id = '';
        $this->kode = '';
        $this->geojson = '';
    }

    public function render(): View
    {
        $wilayah = Wilayah::query()
            ->with('parent')
            ->when($this->search !== '', function ($q): void {
                $term = '%'.$this->search.'%';
                $q->where(fn ($sub) => $sub->where('nama', 'like', $term)->orWhere('kode', 'like', $term));
            })
            ->when($this->tipeFilter !== '', fn ($q) => $q->where('tipe', $this->tipeFilter))
            ->orderBy('tipe')
            ->orderBy('nama')
            ->get();

        $parents = Wilayah::query()
            ->whereIn('tipe', ['desa', 'dusun', 'rw'])
            ->when($this->editingId !== null, fn ($q) => $q->where('id', '!=', $this->editingId))
            ->orderBy('nama')
            ->get();

        return view('livewire.admin.wilayah-table', [
            'wilayah' => $wilayah,
            'parents' => $parents,
        ]);
    }
}
