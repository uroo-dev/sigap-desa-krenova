<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\WithSigapAlerts;
use App\Models\JenisSurat;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Component;

class JenisSuratTable extends Component
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

    public string $deskripsi = '';

    /** @var array<int, string> */
    public array $persyaratan = ['Fotokopi KTP', 'Fotokopi KK'];

    public string $template_isi = '';

    public bool $aktif = true;

    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->showFormModal = true;
    }

    public function openEditModal(int $id): void
    {
        $this->resetValidation();
        $item = JenisSurat::findOrFail($id);

        $this->editingId = $item->id;
        $this->nama = $item->nama;
        $this->deskripsi = $item->deskripsi ?? '';
        $this->persyaratan = count($item->persyaratan ?? []) > 0 ? array_values($item->persyaratan) : [''];
        $this->template_isi = $item->template_isi ?? '';
        $this->aktif = (bool) $item->aktif;
        $this->showFormModal = true;
    }

    public function addSyarat(): void
    {
        $this->persyaratan[] = '';
    }

    public function removeSyarat(int $index): void
    {
        if (count($this->persyaratan) <= 1) {
            $this->persyaratan = [''];

            return;
        }

        unset($this->persyaratan[$index]);
        $this->persyaratan = array_values($this->persyaratan);
    }

    public function save(): void
    {
        $validated = $this->validate([
            'nama' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
            'persyaratan' => ['nullable', 'array'],
            'persyaratan.*' => ['nullable', 'string', 'max:100'],
            'template_isi' => ['nullable', 'string'],
            'aktif' => ['boolean'],
        ]);

        $cleanPersyaratan = array_values(array_filter(
            array_map(static fn (?string $item): string => trim((string) $item), $validated['persyaratan'] ?? []),
            static fn (string $item): bool => $item !== ''
        ));

        $payload = [
            'nama' => $validated['nama'],
            'slug' => $this->generateUniqueSlug($validated['nama'], $this->editingId),
            'deskripsi' => $validated['deskripsi'] !== '' ? $validated['deskripsi'] : null,
            'persyaratan' => $cleanPersyaratan,
            'template_isi' => $validated['template_isi'] !== '' ? $validated['template_isi'] : null,
            'aktif' => $this->aktif,
        ];

        if ($this->editingId) {
            $jenis = JenisSurat::findOrFail($this->editingId);
            $jenis->update($payload);
            $this->closeModals();
            $this->toastSuccess("Jenis surat {$jenis->nama} berhasil diperbarui.");

            return;
        }

        $jenis = JenisSurat::create($payload);
        $this->closeModals();
        $this->toastSuccess("Jenis surat {$jenis->nama} berhasil ditambahkan.");
    }

    public function toggleAktif(int $id): void
    {
        $item = JenisSurat::findOrFail($id);
        $item->update(['aktif' => ! $item->aktif]);

        if ($item->aktif) {
            $this->toastSuccess("Jenis surat {$item->nama} diaktifkan.");
        } else {
            $this->toastInfo("Jenis surat {$item->nama} dinonaktifkan.");
        }
    }

    public function confirmDelete(int $id): void
    {
        $item = JenisSurat::findOrFail($id);
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
            $item = JenisSurat::findOrFail($this->deleteId);
            $nama = $item->nama;
            $item->delete();
            $this->closeModals();
            $this->toastSuccess("Jenis surat {$nama} berhasil dihapus.");
        } catch (\Throwable $e) {
            $this->closeModals();
            $this->toastError('Jenis surat tidak dapat dihapus karena masih digunakan oleh pengajuan surat.');
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
        $this->deskripsi = '';
        $this->persyaratan = ['Fotokopi KTP', 'Fotokopi KK'];
        $this->template_isi = '';
        $this->aktif = true;
    }

    private function generateUniqueSlug(string $nama, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($nama);
        $slug = $baseSlug;
        $counter = 1;

        while (
            JenisSurat::where('slug', $slug)
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
        $jenis = JenisSurat::query()
            ->when($this->search !== '', fn ($q) => $q->where('nama', 'like', '%'.$this->search.'%'))
            ->latest()
            ->get();

        return view('livewire.admin.jenis-surat-table', compact('jenis'));
    }
}
