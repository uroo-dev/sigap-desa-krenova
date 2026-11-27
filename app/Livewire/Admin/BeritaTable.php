<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\WithSigapAlerts;
use App\Models\Berita;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class BeritaTable extends Component
{
    use WithPagination;
    use WithSigapAlerts;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'tipe')]
    public string $tipeFilter = '';

    public bool $showFormModal = false;

    public bool $showDeleteModal = false;

    public ?int $editingId = null;

    public ?int $deleteId = null;

    public string $deleteTitle = '';

    public string $judul = '';

    public string $tipe = 'berita';

    public string $published_at = '';

    public string $ringkasan = '';

    public string $isi = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedTipeFilter(): void
    {
        $this->resetPage();
    }

    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->showFormModal = true;
    }

    public function openEditModal(int $id): void
    {
        $this->resetValidation();
        $item = Berita::findOrFail($id);

        $this->editingId = $item->id;
        $this->judul = $item->judul;
        $this->tipe = $item->tipe;
        $this->published_at = $item->published_at ? $item->published_at->format('Y-m-d\TH:i') : '';
        $this->ringkasan = $item->ringkasan ?? '';
        $this->isi = $item->isi;
        $this->showFormModal = true;
    }

    public function save(): void
    {
        $validated = $this->validate([
            'judul' => ['required', 'string', 'max:200'],
            'tipe' => ['required', 'in:berita,pengumuman,agenda'],
            'published_at' => ['nullable', 'date'],
            'ringkasan' => ['nullable', 'string', 'max:255'],
            'isi' => ['required', 'string'],
        ]);

        $payload = [
            'judul' => $validated['judul'],
            'tipe' => $validated['tipe'],
            'published_at' => ! empty($validated['published_at']) ? $validated['published_at'] : null,
            'ringkasan' => $validated['ringkasan'] !== '' ? $validated['ringkasan'] : null,
            'isi' => $validated['isi'],
        ];

        if ($this->editingId) {
            $berita = Berita::findOrFail($this->editingId);
            $berita->update($payload);
            $this->closeModals();
            $this->toastSuccess("Konten \"{$berita->judul}\" berhasil diperbarui.");

            return;
        }

        $payload['slug'] = Str::slug($validated['judul']).'-'.Str::lower(Str::random(6));
        $payload['user_id'] = Auth::id();

        $berita = Berita::create($payload);
        $this->closeModals();

        if ($berita->published_at) {
            $this->toastSuccess("Konten \"{$berita->judul}\" berhasil diterbitkan.");
        } else {
            $this->toastInfo("Konten \"{$berita->judul}\" disimpan sebagai draf.");
        }
    }

    public function confirmDelete(int $id): void
    {
        $item = Berita::findOrFail($id);
        $this->deleteId = $item->id;
        $this->deleteTitle = $item->judul;
        $this->showDeleteModal = true;
    }

    public function deleteConfirmed(): void
    {
        if ($this->deleteId === null) {
            return;
        }

        $item = Berita::findOrFail($this->deleteId);
        $judul = $item->judul;
        $item->delete();

        $this->closeModals();
        $this->toastSuccess("Konten \"{$judul}\" berhasil dihapus.");
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
        $this->deleteTitle = '';
        $this->judul = '';
        $this->tipe = 'berita';
        $this->published_at = '';
        $this->ringkasan = '';
        $this->isi = '';
    }

    public function render(): View
    {
        $berita = Berita::query()
            ->when($this->search !== '', fn ($q) => $q->where('judul', 'like', '%'.$this->search.'%'))
            ->when($this->tipeFilter !== '', fn ($q) => $q->where('tipe', $this->tipeFilter))
            ->latest()
            ->paginate(15);

        return view('livewire.admin.berita-table', compact('berita'));
    }
}
