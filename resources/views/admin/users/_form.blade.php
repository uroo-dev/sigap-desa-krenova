@php
    $isEdit = isset($user);
    $currentRole = old('role', $isEdit ? $user->roles->first()?->name : '');
    $currentRt = old('rt_id', $isEdit ? $user->rt_id : '');
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <x-input label="Nama Lengkap" name="name" :value="$user->name ?? null" placeholder="Nama lengkap pengguna" required />
    <x-input label="Alamat Email" name="email" type="email" :value="$user->email ?? null" placeholder="email@desa.id" required />
    <x-input label="Nomor HP / WhatsApp" name="no_hp" :value="$user->no_hp ?? null" placeholder="08xxxxxxxxxx" />

    <x-select label="Role Pengguna" name="role" required>
        <option value="">Pilih Role...</option>
        @foreach ($roles as $role)
            <option value="{{ $role->name }}" @selected($currentRole === $role->name)>
                {{ ucwords(str_replace('_', ' ', $role->name)) }}
            </option>
        @endforeach
    </x-select>

    <x-select label="Wilayah RT (Opsional)" name="rt_id" helper="Wajib diisi jika role adalah Ketua RT.">
        <option value="">Tidak Terikat RT</option>
        @foreach ($wilayahRt ?? [] as $rt)
            <option value="{{ $rt->id }}" @selected((string) $currentRt === (string) $rt->id)>
                {{ $rt->nama }}
            </option>
        @endforeach
    </x-select>

    <x-input
        label="{{ $isEdit ? 'Kata Sandi Baru (Opsional)' : 'Kata Sandi' }}"
        name="password"
        type="password"
        :required="! $isEdit"
        placeholder="{{ $isEdit ? 'Kosongkan jika tidak ingin mengubah' : 'Minimal 8 karakter' }}"
    />
</div>

@if ($isEdit)
    <div class="mt-5 pt-4 border-t border-[#E5E7EB]">
        <input type="hidden" name="is_active" value="0">
        <label class="inline-flex items-center gap-2.5 text-sm text-[#1F2937] cursor-pointer">
            <input
                type="checkbox"
                name="is_active"
                value="1"
                @checked(old('is_active', $user->is_active))
                class="rounded border-[#D1D5DB] text-[#1B5E3B] focus:ring-[#1B5E3B]/30"
            >
            <span>Akun aktif (dapat masuk ke sistem)</span>
        </label>
    </div>
@endif
