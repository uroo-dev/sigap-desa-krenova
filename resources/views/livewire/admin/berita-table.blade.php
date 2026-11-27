<div class="space-y-4">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-1">
            <div class="relative flex-1 max-w-sm">
                <i data-lucide="search" class="w-4 h-4 text-[#9CA3AF] absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                <input
                    type="search"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari judul berita atau pengumuman..."
                    class="w-full h-10 pl-10 pr-3.5 rounded-lg border border-[#D1D5DB] bg-white text-sm text-[#1F2937] placeholder-[#9CA3AF] focus:outline-none focus:ring-2 focus:ring-[#1B5E3B]/20 focus:border-[#1B5E3B]"
                >
            </div>

            <select
                wire:model.live="tipeFilter"
                class="h-10 px-3 rounded-lg border border-[#D1D5DB] bg-white text-sm text-[#1F2937] focus:outline-none focus:ring-2 focus:ring-[#1B5E3B]/20 focus:border-[#1B5E3B]"
            >
                <option value="">Semua Tipe</option>
                <option value="berita">Berita</option>
                <option value="pengumuman">Pengumuman</option>
                <option value="agenda">Agenda</option>
            </select>
        </div>

        <x-button type="button" wire:click="openCreateModal" variant="primary" size="md" icon="plus">
            Buat Konten
        </x-button>
    </div>

    <x-card :flush="true">
        @if ($berita->isEmpty())
            <x-empty-state icon="newspaper" title="Belum ada berita atau pengumuman" description="Mulai publikasikan kabar dan agenda desa agar masyarakat selalu terinformasi." />
        @else
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#F8FAF7] border-b border-[#E5E7EB] text-xs font-semibold text-[#6B7280] uppercase tracking-wider">
                            <th class="px-6 py-3.5">Judul</th>
                            <th class="px-6 py-3.5">Tipe</th>
                            <th class="px-6 py-3.5">Status Publikasi</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E5E7EB] text-sm">
                        @foreach ($berita as $item)
                            <tr wire:key="berita-row-{{ $item->id }}" class="hover:bg-[#F8FAF7]/60">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-[#1F2937]">{{ $item->judul }}</div>
                                    <div class="text-xs font-mono text-[#9CA3AF]">{{ $item->slug }}</div>
                                </td>
                                <td class="px-6 py-4"><x-badge tone="primary">{{ ucfirst($item->tipe) }}</x-badge></td>
                                <td class="px-6 py-4">
                                    @if ($item->published_at)
                                        <x-badge tone="success">{{ $item->published_at->format('d M Y H:i') }}</x-badge>
                                    @else
                                        <x-badge tone="neutral">Draf</x-badge>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <x-button type="button" wire:click="openEditModal({{ $item->id }})" variant="outline" size="sm" icon="pencil">Edit</x-button>
                                        <x-button type="button" wire:click="confirmDelete({{ $item->id }})" variant="ghost" size="sm" class="text-[#DC2626] hover:bg-red-50">Hapus</x-button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="md:hidden divide-y divide-[#E5E7EB]">
                @foreach ($berita as $item)
                    <div wire:key="berita-card-{{ $item->id }}" class="p-4 space-y-2">
                        <div class="flex items-center justify-between gap-2">
                            <span class="font-medium text-sm text-[#1F2937]">{{ $item->judul }}</span>
                            <x-badge tone="primary">{{ ucfirst($item->tipe) }}</x-badge>
                        </div>
                        <p class="text-xs text-[#6B7280]">{{ $item->published_at ? 'Terbit '.$item->published_at->format('d M Y') : 'Draf' }}</p>
                        <div class="flex items-center gap-2 pt-1">
                            <x-button type="button" wire:click="openEditModal({{ $item->id }})" variant="outline" size="sm" class="flex-1">Edit</x-button>
                            <x-button type="button" wire:click="confirmDelete({{ $item->id }})" variant="ghost" size="sm" class="text-[#DC2626]">Hapus</x-button>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($berita->hasPages())
                <div class="px-6 py-4 border-t border-[#E5E7EB]">{{ $berita->links() }}</div>
            @endif
        @endif
    </x-card>

    <x-modal :show="$showFormModal" :title="$editingId ? 'Edit Konten Publik' : 'Buat Konten Publik'" maxWidth="2xl">
        <form wire:submit="save" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-[#1F2937] mb-1.5">Judul Konten <span class="text-[#DC2626]">*</span></label>
                <input type="text" wire:model="judul" placeholder="Judul berita, pengumuman, atau agenda" class="w-full h-10 px-3.5 rounded-lg border border-[#D1D5DB] text-sm focus:outline-none focus:ring-2 focus:ring-[#1B5E3B]/20 focus:border-[#1B5E3B]">
                @error('judul') <p class="mt-1 text-xs text-[#DC2626]">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-[#1F2937] mb-1.5">Jenis Konten <span class="text-[#DC2626]">*</span></label>
                    <select wire:model="tipe" class="w-full h-10 px-3 rounded-lg border border-[#D1D5DB] bg-white text-sm focus:outline-none focus:ring-2 focus:ring-[#1B5E3B]/20 focus:border-[#1B5E3B]">
                        <option value="berita">Berita</option>
                        <option value="pengumuman">Pengumuman</option>
                        <option value="agenda">Agenda</option>
                    </select>
                    @error('tipe') <p class="mt-1 text-xs text-[#DC2626]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#1F2937] mb-1.5">Waktu Publikasi (Opsional)</label>
                    <input type="datetime-local" wire:model="published_at" class="w-full h-10 px-3.5 rounded-lg border border-[#D1D5DB] text-sm focus:outline-none focus:ring-2 focus:ring-[#1B5E3B]/20 focus:border-[#1B5E3B]">
                    @error('published_at') <p class="mt-1 text-xs text-[#DC2626]">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-[#1F2937] mb-1.5">Ringkasan (Opsional)</label>
                <textarea wire:model="ringkasan" rows="2" placeholder="Ringkasan singkat..." class="w-full p-3.5 rounded-lg border border-[#D1D5DB] text-sm focus:outline-none focus:ring-2 focus:ring-[#1B5E3B]/20 focus:border-[#1B5E3B]"></textarea>
                @error('ringkasan') <p class="mt-1 text-xs text-[#DC2626]">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#1F2937] mb-1.5">Isi Lengkap <span class="text-[#DC2626]">*</span></label>
                <textarea wire:model="isi" rows="6" placeholder="Tulis isi informasi desa..." class="w-full p-3.5 rounded-lg border border-[#D1D5DB] text-sm focus:outline-none focus:ring-2 focus:ring-[#1B5E3B]/20 focus:border-[#1B5E3B]"></textarea>
                @error('isi') <p class="mt-1 text-xs text-[#DC2626]">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-[#E5E7EB]">
                <x-button type="button" wire:click="closeModals" variant="outline" size="md">Batal</x-button>
                <x-button type="submit" wire:loading.attr="disabled" variant="primary" size="md" icon="save">
                    <span wire:loading.remove wire:target="save">{{ $editingId ? 'Simpan Perubahan' : 'Simpan Konten' }}</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </x-button>
            </div>
        </form>
    </x-modal>

    <x-modal :show="$showDeleteModal" title="Hapus Konten?" maxWidth="md">
        <p class="text-sm text-[#6B7280]">Hapus konten <strong class="text-[#1F2937]">{{ $deleteTitle }}</strong>?</p>
        <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-[#E5E7EB]">
            <x-button type="button" wire:click="closeModals" variant="outline" size="md">Batal</x-button>
            <x-button type="button" wire:click="deleteConfirmed" wire:loading.attr="disabled" variant="danger" size="md">Ya, Hapus</x-button>
        </div>
    </x-modal>
</div>
