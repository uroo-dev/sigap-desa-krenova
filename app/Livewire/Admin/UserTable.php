<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UserTable extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'role')]
    public string $roleFilter = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedRoleFilter(): void
    {
        $this->resetPage();
    }

    /**
     * Aktifkan atau nonaktifkan akun pengguna secara reaktif tanpa reload halaman.
     */
    public function toggleActive(int $userId): void
    {
        $target = User::findOrFail($userId);

        if ($target->id === Auth::id()) {
            return;
        }

        $target->update([
            'is_active' => ! $target->is_active,
        ]);
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
        ]);
    }
}
