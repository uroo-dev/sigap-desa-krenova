<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\WithSigapAlerts;
use App\Models\KategoriLaporan;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Component;

class KategoriLaporanTable extends Component
{
    use WithSigapAlerts;

    #[Url(as: 'q')]
    public string $search = '';

    public bool $showFormModal = false;

    public bool $showDeleteModal = false;

    public ?int $editingId = null;

    public ?int $deleteId = null;

    public string $deleteName = '';

    public string $nama = '';

    public string $ikon = '';

    public string $deskripsi = '';

    public bool $aktif = true;

    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->showFormModal = true;
    }

    public function openEditModal(int $id): void
    {
        $this->resetValidation();
        $item = KategoriLaporan::findOrFail($id);

        $this->editingId = $item->id;
        $this->nama = $item->nama;
        $this->ikon = $item->ikon ?? '';
        $this->deskripsi = $item->deskripsi ?? '';
        $this->aktif = (bool) $item->aktif;
        $this->showFormModal = true;
    }

    public function save(): void
    {
        $validated = $this->validate([
            'nama' => ['required', 'string', 'max:100'],
            'ikon' => ['nullable', 'string', 'max:64'],
            'deskripsi' => ['nullable', 'string'],
            'aktif' => ['boolean'],
        ]);

        $slug = $this->generateUniqueSlug($validated['nama'], $this->editingId);

        $payload = [
            'nama' => $validated['nama'],
            'slug' => $slug,
            'ikon' => $validated['ikon'] !== '' ? $validated['ikon'] : null,
            'deskripsi' => $validated['deskripsi'] !== '' ? $validated['deskripsi'] : null,
            'aktif' => $this->aktif,
        ];

        if ($this->editingId) {
            $kategori = KategoriLaporan::findOrFail($this->editingId);
            $kategori->update($payload);
            $this->closeModals();
            $this->toastSuccess("Kategori {$kategori->nama} berhasil diperbarui.");

            return;
        }

        $kategori = KategoriLaporan::create($payload);
        $this->closeModals();
        $this->toastSuccess("Kategori {$kategori->nama} berhasil ditambahkan.");
    }

    public function toggleAktif(int $id): void
    {
        $item = KategoriLaporan::findOrFail($id);
        $item->update(['aktif' => ! $item->aktif]);

        if ($item->aktif) {
            $this->toastSuccess("Kategori {$item->nama} diaktifkan.");
        } else {
            $this->toastInfo("Kategori {$item->nama} dinonaktifkan.");
        }
    }

    public function confirmDelete(int $id): void
    {
        $item = KategoriLaporan::findOrFail($id);
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
            $item = KategoriLaporan::findOrFail($this->deleteId);
            $nama = $item->nama;
            $item->delete();
            $this->closeModals();
            $this->toastSuccess("Kategori {$nama} berhasil dihapus.");
        } catch (\Throwable $e) {
            $this->closeModals();
            $this->toastError('Kategori tidak dapat dihapus karena masih digunakan oleh laporan warga.');
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
        $this->nama = '';
        $this->ikon = '';
        $this->deskripsi = '';
        $this->aktif = true;
    }

    private function generateUniqueSlug(string $nama, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($nama);
        $slug = $baseSlug;
        $counter = 1;

        while (
            KategoriLaporan::where('slug', $slug)
                ->when($ignoreId !== null, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    public function render(): View
    {
        $kategori = KategoriLaporan::query()
            ->when($this->search !== '', fn ($q) => $q->where('nama', 'like', '%'.$this->search.'%'))
            ->latest()
            ->get();

        return view('livewire.admin.kategori-laporan-table', compact('kategori'));
    }
}
