<div class="space-y-4">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-1">
            <div class="relative flex-1 max-w-sm">
                <i data-lucide="search" class="w-4 h-4 text-[#9CA3AF] absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                <input
                    type="search"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari nama atau kode wilayah..."
                    class="w-full h-10 pl-10 pr-3.5 rounded-lg border border-[#D1D5DB] bg-white text-sm text-[#1F2937] placeholder-[#9CA3AF] focus:outline-none focus:ring-2 focus:ring-[#1B5E3B]/20 focus:border-[#1B5E3B]"
                >
            </div>

            <select
                wire:model.live="tipeFilter"
                class="h-10 px-3 rounded-lg border border-[#D1D5DB] bg-white text-sm text-[#1F2937] focus:outline-none focus:ring-2 focus:ring-[#1B5E3B]/20 focus:border-[#1B5E3B]"
            >
                <option value="">Semua Tingkat</option>
                <option value="desa">Desa</option>
                <option value="dusun">Dusun</option>
                <option value="rw">RW</option>
                <option value="rt">RT</option>
            </select>
        </div>

        <x-button type="button" wire:click="openCreateModal" variant="primary" size="md" icon="plus">
            Tambah Wilayah
        </x-button>
    </div>

    <x-card :flush="true">
        @if ($wilayah->isEmpty())
            <x-empty-state icon="map-pin" title="Belum ada data wilayah" description="Tambahkan data Desa, Dusun, RW, atau RT beserta GeoJSON." />
        @else
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#F8FAF7] border-b border-[#E5E7EB] text-xs font-semibold text-[#6B7280] uppercase tracking-wider">
                            <th class="px-6 py-3.5">Nama Wilayah</th>
                            <th class="px-6 py-3.5">Tingkat</th>
                            <th class="px-6 py-3.5">Induk</th>
                            <th class="px-6 py-3.5">Kode</th>
                            <th class="px-6 py-3.5">GeoJSON</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E5E7EB] text-sm">
                        @foreach ($wilayah as $item)
                            <tr wire:key="wilayah-row-{{ $item->id }}" class="hover:bg-[#F8FAF7]/60">
                                <td class="px-6 py-4 font-medium text-[#1F2937]">{{ $item->nama }}</td>
                                <td class="px-6 py-4"><x-badge tone="primary">{{ strtoupper($item->tipe) }}</x-badge></td>
                                <td class="px-6 py-4 text-[#6B7280]">{{ $item->parent?->nama ?? '-' }}</td>
                                <td class="px-6 py-4 font-mono text-xs text-[#6B7280]">{{ $item->kode ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <x-badge :tone="$item->geojson ? 'success' : 'neutral'">{{ $item->geojson ? 'Tersedia' : 'Kosong' }}</x-badge>
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
                @foreach ($wilayah as $item)
                    <div wire:key="wilayah-card-{{ $item->id }}" class="p-4 space-y-2">
                        <div class="flex items-center justify-between gap-2">
                            <span class="font-medium text-sm text-[#1F2937]">{{ $item->nama }}</span>
                            <x-badge tone="primary">{{ strtoupper($item->tipe) }}</x-badge>
                        </div>
                        <p class="text-xs text-[#6B7280]">Induk: {{ $item->parent?->nama ?? '-' }} · Kode: {{ $item->kode ?? '-' }}</p>
                        <div class="flex items-center gap-2 pt-1">
                            <x-button type="button" wire:click="openEditModal({{ $item->id }})" variant="outline" size="sm" class="flex-1">Edit</x-button>
                            <x-button type="button" wire:click="confirmDelete({{ $item->id }})" variant="ghost" size="sm" class="text-[#DC2626]">Hapus</x-button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </x-card>

    {{-- Modal Tambah / Edit Wilayah --}}
    <x-modal :show="$showFormModal" :title="$editingId ? 'Edit Wilayah' : 'Tambah Wilayah Baru'" maxWidth="xl">
        <form wire:submit="save" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-[#1F2937] mb-1.5">Tingkat Wilayah <span class="text-[#DC2626]">*</span></label>
                    <select wire:model="tipe" class="w-full h-10 px-3 rounded-lg border border-[#D1D5DB] bg-white text-sm focus:outline-none focus:ring-2 focus:ring-[#1B5E3B]/20 focus:border-[#1B5E3B]">
                        <option value="desa">Desa</option>
                        <option value="dusun">Dusun</option>
                        <option value="rw">RW</option>
                        <option value="rt">RT</option>
                    </select>
                    @error('tipe') <p class="mt-1 text-xs text-[#DC2626]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#1F2937] mb-1.5">Wilayah Induk</label>
                    <select wire:model="parent_id" class="w-full h-10 px-3 rounded-lg border border-[#D1D5DB] bg-white text-sm focus:outline-none focus:ring-2 focus:ring-[#1B5E3B]/20 focus:border-[#1B5E3B]">
                        <option value="">Tanpa Induk (Tingkat Desa)</option>
                        @foreach ($parents as $parent)
                            <option value="{{ $parent->id }}">[{{ strtoupper($parent->tipe) }}] {{ $parent->nama }}</option>
                        @endforeach
                    </select>
                    @error('parent_id') <p class="mt-1 text-xs text-[#DC2626]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#1F2937] mb-1.5">Nama Wilayah <span class="text-[#DC2626]">*</span></label>
                    <input type="text" wire:model="nama" placeholder="Contoh: RT 01" class="w-full h-10 px-3.5 rounded-lg border border-[#D1D5DB] text-sm focus:outline-none focus:ring-2 focus:ring-[#1B5E3B]/20 focus:border-[#1B5E3B]">
                    @error('nama') <p class="mt-1 text-xs text-[#DC2626]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#1F2937] mb-1.5">Kode Wilayah</label>
                    <input type="text" wire:model="kode" placeholder="Contoh: RT-01" class="w-full h-10 px-3.5 rounded-lg border border-[#D1D5DB] text-sm focus:outline-none focus:ring-2 focus:ring-[#1B5E3B]/20 focus:border-[#1B5E3B]">
                    @error('kode') <p class="mt-1 text-xs text-[#DC2626]">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-[#1F2937] mb-1.5">Data Poligon GeoJSON (Opsional)</label>
                <textarea wire:model="geojson" rows="5" placeholder='{"type":"Polygon","coordinates":[...]}' class="w-full p-3.5 rounded-lg border border-[#D1D5DB] font-mono text-xs focus:outline-none focus:ring-2 focus:ring-[#1B5E3B]/20 focus:border-[#1B5E3B]"></textarea>
                @error('geojson') <p class="mt-1 text-xs text-[#DC2626]">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-[#E5E7EB]">
                <x-button type="button" wire:click="closeModals" variant="outline" size="md">Batal</x-button>
                <x-button type="submit" wire:loading.attr="disabled" variant="primary" size="md" icon="save">
                    <span wire:loading.remove wire:target="save">{{ $editingId ? 'Simpan Perubahan' : 'Simpan Wilayah' }}</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </x-button>
            </div>
        </form>
    </x-modal>

    {{-- Modal Konfirmasi Hapus Wilayah --}}
    <x-modal :show="$showDeleteModal" title="Hapus Wilayah?" maxWidth="md">
        <p class="text-sm text-[#6B7280]">
            Apakah Anda yakin ingin menghapus wilayah <strong class="text-[#1F2937]">{{ $deleteName }}</strong>?
        </p>
        <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-[#E5E7EB]">
            <x-button type="button" wire:click="closeModals" variant="outline" size="md">Batal</x-button>
            <x-button type="button" wire:click="deleteConfirmed" wire:loading.attr="disabled" variant="danger" size="md">Ya, Hapus</x-button>
        </div>
    </x-modal>
</div>
