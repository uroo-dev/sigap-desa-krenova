<div class="space-y-4">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="relative flex-1 max-w-sm">
            <i data-lucide="search" class="w-4 h-4 text-[#9CA3AF] absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
            <input
                type="search"
                wire:model.live.debounce.300ms="search"
                placeholder="Cari kategori laporan..."
                class="w-full h-10 pl-10 pr-3.5 rounded-lg border border-[#D1D5DB] bg-white text-sm text-[#1F2937] placeholder-[#9CA3AF] focus:outline-none focus:ring-2 focus:ring-[#1B5E3B]/20 focus:border-[#1B5E3B]"
            >
        </div>

        <x-button type="button" wire:click="openCreateModal" variant="primary" size="md" icon="plus">
            Tambah Kategori
        </x-button>
    </div>

    <x-card :flush="true">
        @if ($kategori->isEmpty())
            <x-empty-state icon="clipboard-list" title="Belum ada kategori laporan" description="Tambahkan kategori seperti Jalan Rusak, Drainase, atau Lampu Jalan." />
        @else
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#F8FAF7] border-b border-[#E5E7EB] text-xs font-semibold text-[#6B7280] uppercase tracking-wider">
                            <th class="px-6 py-3.5">Kategori</th>
                            <th class="px-6 py-3.5">Slug</th>
                            <th class="px-6 py-3.5">Status</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E5E7EB] text-sm">
                        @foreach ($kategori as $item)
                            <tr wire:key="kat-row-{{ $item->id }}" class="hover:bg-[#F8FAF7]/60">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-[#1F2937]">{{ $item->nama }}</div>
                                    @if ($item->deskripsi)
                                        <div class="text-xs text-[#6B7280] mt-0.5">{{ $item->deskripsi }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-mono text-xs text-[#6B7280]">{{ $item->slug }}</td>
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
                @foreach ($kategori as $item)
                    <div wire:key="kat-card-{{ $item->id }}" class="p-4 space-y-2">
                        <div class="flex items-center justify-between gap-2">
                            <span class="font-medium text-sm text-[#1F2937]">{{ $item->nama }}</span>
                            <button type="button" wire:click="toggleAktif({{ $item->id }})">
                                <x-badge :tone="$item->aktif ? 'success' : 'neutral'">{{ $item->aktif ? 'Aktif' : 'Nonaktif' }}</x-badge>
                            </button>
                        </div>
                        <p class="text-xs text-[#6B7280]">{{ $item->deskripsi ?: $item->slug }}</p>
                        <div class="flex items-center gap-2 pt-1">
                            <x-button type="button" wire:click="openEditModal({{ $item->id }})" variant="outline" size="sm" class="flex-1">Edit</x-button>
                            <x-button type="button" wire:click="confirmDelete({{ $item->id }})" variant="ghost" size="sm" class="text-[#DC2626]">Hapus</x-button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </x-card>

    <x-modal :show="$showFormModal" :title="$editingId ? 'Edit Kategori Laporan' : 'Tambah Kategori Laporan'" maxWidth="lg">
        <form wire:submit="save" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-[#1F2937] mb-1.5">Nama Kategori <span class="text-[#DC2626]">*</span></label>
                    <input type="text" wire:model="nama" placeholder="Contoh: Jalan & Jembatan" class="w-full h-10 px-3.5 rounded-lg border border-[#D1D5DB] text-sm focus:outline-none focus:ring-2 focus:ring-[#1B5E3B]/20 focus:border-[#1B5E3B]">
                    @error('nama') <p class="mt-1 text-xs text-[#DC2626]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#1F2937] mb-1.5">Ikon Lucide (Opsional)</label>
                    <input type="text" wire:model="ikon" placeholder="alert-triangle" class="w-full h-10 px-3.5 rounded-lg border border-[#D1D5DB] text-sm focus:outline-none focus:ring-2 focus:ring-[#1B5E3B]/20 focus:border-[#1B5E3B]">
                    @error('ikon') <p class="mt-1 text-xs text-[#DC2626]">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-[#1F2937] mb-1.5">Deskripsi</label>
                <textarea wire:model="deskripsi" rows="3" placeholder="Penjelasan singkat kategori laporan..." class="w-full p-3.5 rounded-lg border border-[#D1D5DB] text-sm focus:outline-none focus:ring-2 focus:ring-[#1B5E3B]/20 focus:border-[#1B5E3B]"></textarea>
                @error('deskripsi') <p class="mt-1 text-xs text-[#DC2626]">{{ $message }}</p> @enderror
            </div>

            <label class="inline-flex items-center gap-2 text-sm text-[#1F2937] cursor-pointer">
                <input type="checkbox" wire:model="aktif" class="rounded border-[#D1D5DB] text-[#1B5E3B] focus:ring-[#1B5E3B]/30">
                <span>Kategori aktif</span>
            </label>

            <div class="flex justify-end gap-3 pt-4 border-t border-[#E5E7EB]">
                <x-button type="button" wire:click="closeModals" variant="outline" size="md">Batal</x-button>
                <x-button type="submit" wire:loading.attr="disabled" variant="primary" size="md" icon="save">
                    <span wire:loading.remove wire:target="save">{{ $editingId ? 'Simpan Perubahan' : 'Simpan Kategori' }}</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </x-button>
            </div>
        </form>
    </x-modal>

    <x-modal :show="$showDeleteModal" title="Hapus Kategori?" maxWidth="md">
        <p class="text-sm text-[#6B7280]">Hapus kategori <strong class="text-[#1F2937]">{{ $deleteName }}</strong> dari daftar master?</p>
        <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-[#E5E7EB]">
            <x-button type="button" wire:click="closeModals" variant="outline" size="md">Batal</x-button>
            <x-button type="button" wire:click="deleteConfirmed" wire:loading.attr="disabled" variant="danger" size="md">Ya, Hapus</x-button>
        </div>
    </x-modal>
</div>
