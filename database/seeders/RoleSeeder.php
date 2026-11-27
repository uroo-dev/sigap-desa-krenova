<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (RoleName::cases() as $role) {
            Role::firstOrCreate(['name' => $role->value]);
        }

        $admin = User::firstOrCreate(
            ['email' => 'admin@sigap.test'],
            [
                'name' => 'Admin SIGAP',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );

        if (! $admin->hasVerifiedEmail()) {
            $admin->markEmailAsVerified();
        }

        $admin->assignRole(RoleName::ADMIN->value);
    }
}
