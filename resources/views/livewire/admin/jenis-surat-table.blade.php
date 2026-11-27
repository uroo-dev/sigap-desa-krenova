<div class="space-y-4">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="relative flex-1 max-w-sm">
            <i data-lucide="search" class="w-4 h-4 text-[#9CA3AF] absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
            <input
                type="search"
                wire:model.live.debounce.300ms="search"
                placeholder="Cari jenis layanan surat..."
                class="w-full h-10 pl-10 pr-3.5 rounded-lg border border-[#D1D5DB] bg-white text-sm text-[#1F2937] placeholder-[#9CA3AF] focus:outline-none focus:ring-2 focus:ring-[#1B5E3B]/20 focus:border-[#1B5E3B]"
            >
        </div>

        <x-button type="button" wire:click="openCreateModal" variant="primary" size="md" icon="plus">
            Tambah Jenis Surat
        </x-button>
    </div>

    <x-card :flush="true">
        @if ($jenis->isEmpty())
            <x-empty-state icon="file-text" title="Belum ada jenis surat" description="Tambahkan jenis layanan surat seperti Domisili, Usaha, atau Pengantar SKCK." />
        @else
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#F8FAF7] border-b border-[#E5E7EB] text-xs font-semibold text-[#6B7280] uppercase tracking-wider">
                            <th class="px-6 py-3.5">Nama Layanan Surat</th>
                            <th class="px-6 py-3.5">Persyaratan</th>
                            <th class="px-6 py-3.5">Status</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E5E7EB] text-sm">
                        @foreach ($jenis as $item)
                            <tr wire:key="surat-row-{{ $item->id }}" class="hover:bg-[#F8FAF7]/60">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-[#1F2937]">{{ $item->nama }}</div>
                                    <div class="text-xs font-mono text-[#9CA3AF]">{{ $item->slug }}</div>
                                </td>
                                <td class="px-6 py-4 text-xs text-[#6B7280]">{{ count($item->persyaratan ?? []) }} syarat</td>
                                <td class="px-6 py-4">
                                    <button type="button" wire:click="toggleAktif({{ $item->id }})" class="cursor-pointer">
                                        <x-badge :tone="$item->aktif ? 'success' : 'neutral'">{{ $item->aktif ? 'Aktif' : 'Nonaktif' }}</x-badge>
                                    </button>
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
                @foreach ($jenis as $item)
                    <div wire:key="surat-card-{{ $item->id }}" class="p-4 space-y-2">
                        <div class="flex items-center justify-between gap-2">
                            <span class="font-medium text-sm text-[#1F2937]">{{ $item->nama }}</span>
                            <button type="button" wire:click="toggleAktif({{ $item->id }})">
                                <x-badge :tone="$item->aktif ? 'success' : 'neutral'">{{ $item->aktif ? 'Aktif' : 'Nonaktif' }}</x-badge>
                            </button>
                        </div>
                        <p class="text-xs text-[#6B7280]">{{ count($item->persyaratan ?? []) }} syarat</p>
                        <div class="flex items-center gap-2 pt-1">
                            <x-button type="button" wire:click="openEditModal({{ $item->id }})" variant="outline" size="sm" class="flex-1">Edit</x-button>
                            <x-button type="button" wire:click="confirmDelete({{ $item->id }})" variant="ghost" size="sm" class="text-[#DC2626]">Hapus</x-button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </x-card>

    <x-modal :show="$showFormModal" :title="$editingId ? 'Edit Jenis Surat' : 'Tambah Jenis Surat'" maxWidth="xl">
        <form wire:submit="save" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-[#1F2937] mb-1.5">Nama Jenis Surat <span class="text-[#DC2626]">*</span></label>
                <input type="text" wire:model="nama" placeholder="Contoh: Surat Keterangan Domisili" class="w-full h-10 px-3.5 rounded-lg border border-[#D1D5DB] text-sm focus:outline-none focus:ring-2 focus:ring-[#1B5E3B]/20 focus:border-[#1B5E3B]">
                @error('nama') <p class="mt-1 text-xs text-[#DC2626]">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#1F2937] mb-1.5">Deskripsi</label>
                <textarea wire:model="deskripsi" rows="2" placeholder="Keterangan kegunaan surat..." class="w-full p-3.5 rounded-lg border border-[#D1D5DB] text-sm focus:outline-none focus:ring-2 focus:ring-[#1B5E3B]/20 focus:border-[#1B5E3B]"></textarea>
                @error('deskripsi') <p class="mt-1 text-xs text-[#DC2626]">{{ $message }}</p> @enderror
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-sm font-medium text-[#1F2937]">Daftar Persyaratan</label>
                    <button type="button" wire:click="addSyarat" class="text-xs font-medium text-[#1B5E3B] hover:text-[#15452D] inline-flex items-center gap-1">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                        Tambah Syarat
                    </button>
                </div>
                <div class="space-y-2">
                    @foreach ($persyaratan as $idx => $syarat)
                        <div wire:key="syarat-{{ $idx }}" class="flex items-center gap-2">
                            <input
                                type="text"
                                wire:model="persyaratan.{{ $idx }}"
                                placeholder="Contoh: Fotokopi KTP"
                                class="flex-1 h-10 px-3.5 rounded-lg border border-[#D1D5DB] text-sm focus:outline-none focus:ring-2 focus:ring-[#1B5E3B]/20 focus:border-[#1B5E3B]"
                            >
                            <button
                                type="button"
                                wire:click="removeSyarat({{ $idx }})"
                                class="h-10 px-3 rounded-lg border border-[#E5E7EB] text-[#6B7280] hover:text-[#DC2626] hover:bg-red-50"
                            >
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-[#1F2937] mb-1.5">Template Isi Surat (Opsional)</label>
                <textarea wire:model="template_isi" rows="4" placeholder="Template paragraf isi surat..." class="w-full p-3.5 rounded-lg border border-[#D1D5DB] text-sm focus:outline-none focus:ring-2 focus:ring-[#1B5E3B]/20 focus:border-[#1B5E3B]"></textarea>
            </div>

            <label class="inline-flex items-center gap-2 text-sm text-[#1F2937] cursor-pointer">
                <input type="checkbox" wire:model="aktif" class="rounded border-[#D1D5DB] text-[#1B5E3B] focus:ring-[#1B5E3B]/30">
                <span>Jenis surat aktif</span>
            </label>

            <div class="flex justify-end gap-3 pt-4 border-t border-[#E5E7EB]">
                <x-button type="button" wire:click="closeModals" variant="outline" size="md">Batal</x-button>
                <x-button type="submit" wire:loading.attr="disabled" variant="primary" size="md" icon="save">
                    <span wire:loading.remove wire:target="save">{{ $editingId ? 'Simpan Perubahan' : 'Simpan Jenis Surat' }}</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </x-button>
            </div>
        </form>
    </x-modal>

    <x-modal :show="$showDeleteModal" title="Hapus Jenis Surat?" maxWidth="md">
        <p class="text-sm text-[#6B7280]">Hapus layanan surat <strong class="text-[#1F2937]">{{ $deleteName }}</strong>?</p>
        <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-[#E5E7EB]">
            <x-button type="button" wire:click="closeModals" variant="outline" size="md">Batal</x-button>
            <x-button type="button" wire:click="deleteConfirmed" wire:loading.attr="disabled" variant="danger" size="md">Ya, Hapus</x-button>
        </div>
    </x-modal>
</div>
