<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Article::truncate();
        Role::truncate();
        Schema::enableForeignKeyConstraints();

        User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@example.com',
        ]);


        $model = User::factory()->create([
            'name' => 'Test moderator',
            'email' => 'moderator@example.com',
        ]);
        Article::factory()->create([
            'user_id' => $model->id,
        ]);

        $this->call([
            RoleAndPermissionSeeder::class,
        ]);
    }
}
