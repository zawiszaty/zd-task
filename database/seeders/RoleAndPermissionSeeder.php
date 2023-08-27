<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        Role::create(['name' => 'admin'])->save();
        Role::create(['name' => 'moderator'])->save();
        Role::create(['name' => 'user'])->save();
        $admin = User::where('email', 'admin@example.com')->first();
        $admin->assignRole('admin');
        $admin->assignRole('user');
        $moderator = User::where('email', 'moderator@example.com')->first();
        $moderator->assignRole('moderator');
        $moderator->assignRole('user');
        $user = User::where('email', 'user@example.com')->first();
        $user->assignRole('user');
    }
}
