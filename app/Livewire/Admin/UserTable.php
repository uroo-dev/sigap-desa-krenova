<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\WithSigapAlerts;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UserTable extends Component
{
    use WithPagination;
    use WithSigapAlerts;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'role')]
    public string $roleFilter = '';

    public bool $showFormModal = false;

    public bool $showConfirmModal = false;

    public ?int $editingId = null;

    public ?int $targetId = null;

    public string $targetName = '';

    public bool $targetIsActive = true;

    public string $name = '';

    public string $email = '';

    public string $no_hp = '';

    public string $role = '';

    public string $rt_id = '';

    public string $password = '';

    public bool $is_active = true;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedRoleFilter(): void
    {
        $this->resetPage();
    }

    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->showFormModal = true;
    }

    public function openEditModal(int $userId): void
    {
        $this->resetValidation();
        $user = User::with('roles')->findOrFail($userId);

        $this->editingId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->no_hp = $user->no_hp ?? '';
        $this->role = $user->roles->first()?->name ?? '';
        $this->rt_id = $user->rt_id ? (string) $user->rt_id : '';
        $this->password = '';
        $this->is_active = (bool) $user->is_active;
        $this->showFormModal = true;
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->editingId)],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'role' => ['required', 'exists:roles,name'],
            'rt_id' => ['nullable', 'exists:wilayah,id'],
            'password' => [$this->editingId ? 'nullable' : 'required', 'string', 'min:8'],
            'is_active' => ['boolean'],
        ]);

        if ($this->editingId) {
            $user = User::findOrFail($this->editingId);
            $payload = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'no_hp' => $validated['no_hp'] !== '' ? $validated['no_hp'] : null,
                'rt_id' => $validated['rt_id'] !== '' ? (int) $validated['rt_id'] : null,
                'is_active' => $user->id === Auth::id() ? true : $this->is_active,
            ];

            if (! empty($validated['password'])) {
                $payload['password'] = Hash::make($validated['password']);
            }

            $user->update($payload);
            $user->syncRoles([$validated['role']]);

            $this->closeModals();
            $this->toastSuccess("Data pengguna {$user->name} berhasil diperbarui.");

            return;
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'] !== '' ? $validated['no_hp'] : null,
            'rt_id' => $validated['rt_id'] !== '' ? (int) $validated['rt_id'] : null,
            'password' => Hash::make($validated['password']),
            'is_active' => true,
        ]);
        $user->assignRole($validated['role']);

        $this->closeModals();
        $this->toastSuccess("Pengguna {$user->name} berhasil ditambahkan.");
    }

    public function confirmToggleStatus(int $userId): void
    {
        $target = User::findOrFail($userId);

        if ($target->id === Auth::id()) {
            $this->toastError('Anda tidak dapat menonaktifkan akun Anda sendiri.');

            return;
        }

        $this->targetId = $target->id;
        $this->targetName = $target->name;
        $this->targetIsActive = (bool) $target->is_active;
        $this->showConfirmModal = true;
    }

    public function toggleActiveConfirmed(): void
    {
        if ($this->targetId === null) {
            return;
        }

        $target = User::findOrFail($this->targetId);

        if ($target->id === Auth::id()) {
            $this->closeModals();
            $this->toastError('Anda tidak dapat menonaktifkan akun Anda sendiri.');

            return;
        }

        $nextState = ! $target->is_active;
        $target->update(['is_active' => $nextState]);
        $this->closeModals();

        if ($nextState) {
            $this->toastSuccess("Akun {$target->name} berhasil diaktifkan kembali.");
        } else {
            $this->toastInfo("Akun {$target->name} telah dinonaktifkan.");
        }
    }

    public function closeModals(): void
    {
        $this->showFormModal = false;
        $this->showConfirmModal = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->resetValidation();
        $this->editingId = null;
        $this->targetId = null;
        $this->targetName = '';
        $this->targetIsActive = true;
        $this->name = '';
        $this->email = '';
        $this->no_hp = '';
        $this->role = '';
        $this->rt_id = '';
        $this->password = '';
        $this->is_active = true;
    }

    public function render(): View
    {
        $users = User::query()
            ->with(['roles', 'wilayah'])
            ->when($this->search !== '', function ($query): void {
                $term = '%'.$this->search.'%';
                $query->where(function ($sub) use ($term): void {
                    $sub->where('name', 'like', $term)
                        ->orWhere('email', 'like', $term)
                        ->orWhere('no_hp', 'like', $term);
                });
            })
            ->when($this->roleFilter !== '', function ($query): void {
                $query->whereHas('roles', fn ($q) => $q->where('name', $this->roleFilter));
            })
            ->latest()
            ->paginate(15);

        return view('livewire.admin.user-table', [
            'users' => $users,
            'roles' => Role::orderBy('name')->get(),
            'wilayahRt' => Wilayah::rt()->orderBy('nama')->get(),
        ]);
    }
}
