<div class="space-y-4">
    {{-- Toolbar Pencarian & Filter --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-1">
            <div class="relative flex-1 max-w-sm">
                <i data-lucide="search" class="w-4 h-4 text-[#9CA3AF] absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                <input
                    type="search"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari nama, email, atau no. HP..."
                    class="w-full h-10 pl-10 pr-3.5 rounded-lg border border-[#D1D5DB] bg-white text-sm text-[#1F2937] placeholder-[#9CA3AF] focus:outline-none focus:ring-2 focus:ring-[#1B5E3B]/20 focus:border-[#1B5E3B]"
                >
            </div>

            <select
                wire:model.live="roleFilter"
                class="h-10 px-3 rounded-lg border border-[#D1D5DB] bg-white text-sm text-[#1F2937] focus:outline-none focus:ring-2 focus:ring-[#1B5E3B]/20 focus:border-[#1B5E3B]"
            >
                <option value="">Semua Role</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{ ucwords(str_replace('_', ' ', $role->name)) }}</option>
                @endforeach
            </select>
        </div>

        <div wire:loading class="text-xs text-[#1B5E3B] font-medium inline-flex items-center gap-1.5">
            <i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
            <span>Memuat data...</span>
        </div>
    </div>

    <x-card :flush="true">
        @if ($users->isEmpty())
            <x-empty-state
                icon="users"
                title="Pengguna tidak ditemukan"
                description="Ubah kata kunci pencarian atau tambahkan pengguna baru."
            />
        @else
            {{-- Tabel Desktop --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#F8FAF7] border-b border-[#E5E7EB] text-xs font-semibold text-[#6B7280] uppercase tracking-wider">
                            <th class="px-6 py-3.5">Pengguna</th>
                            <th class="px-6 py-3.5">Role</th>
                            <th class="px-6 py-3.5">Wilayah RT</th>
                            <th class="px-6 py-3.5">Status</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E5E7EB] text-sm">
                        @foreach ($users as $user)
                            <tr wire:key="user-row-{{ $user->id }}" class="hover:bg-[#F8FAF7]/60 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-[#1F2937]">{{ $user->name }}</div>
                                    <div class="text-xs text-[#6B7280]">{{ $user->email }}</div>
                                    @if ($user->no_hp)
                                        <div class="text-xs text-[#9CA3AF]">{{ $user->no_hp }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @forelse ($user->roles as $role)
                                        <x-badge tone="primary">{{ ucwords(str_replace('_', ' ', $role->name)) }}</x-badge>
                                    @empty
                                        <x-badge tone="neutral">Tanpa Role</x-badge>
                                    @endforelse
                                </td>
                                <td class="px-6 py-4 text-[#6B7280]">
                                    {{ $user->wilayah?->nama ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <x-badge :tone="$user->is_active ? 'success' : 'danger'">
                                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </x-badge>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <x-button :href="route('admin.users.edit', $user)" :navigate="true" variant="outline" size="sm" icon="pencil">
                                            Edit
                                        </x-button>

                                        @if ($user->id !== auth()->id())
                                            <x-button
                                                type="button"
                                                wire:click="toggleActive({{ $user->id }})"
                                                :variant="$user->is_active ? 'ghost' : 'secondary'"
                                                size="sm"
                                            >
                                                {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </x-button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Daftar Card Mobile --}}
            <div class="md:hidden divide-y divide-[#E5E7EB]">
                @foreach ($users as $user)
                    <div wire:key="user-card-{{ $user->id }}" class="p-4 space-y-3">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="font-medium text-sm text-[#1F2937]">{{ $user->name }}</p>
                                <p class="text-xs text-[#6B7280]">{{ $user->email }}</p>
                            </div>
                            <x-badge :tone="$user->is_active ? 'success' : 'danger'">
                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                            </x-badge>
                        </div>
                        <div class="flex flex-wrap items-center gap-2 text-xs text-[#6B7280]">
                            @foreach ($user->roles as $role)
                                <x-badge tone="primary">{{ ucwords(str_replace('_', ' ', $role->name)) }}</x-badge>
                            @endforeach
                            <span>RT: {{ $user->wilayah?->nama ?? '-' }}</span>
                        </div>
                        <div class="flex items-center gap-2 pt-1">
                            <x-button :href="route('admin.users.edit', $user)" :navigate="true" variant="outline" size="sm" class="flex-1">Edit</x-button>
                            @if ($user->id !== auth()->id())
                                <x-button type="button" wire:click="toggleActive({{ $user->id }})" variant="ghost" size="sm">
                                    {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </x-button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($users->hasPages())
                <div class="px-6 py-4 border-t border-[#E5E7EB]">
                    {{ $users->links() }}
                </div>
            @endif
        @endif
    </x-card>
</div>
