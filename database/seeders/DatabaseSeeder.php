<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        // \App\Models\Post::factory(100)->create();

        $adminUser = \App\Models\User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'test@example.com',
            'password'=> bcrypt('admin123')
        ]);
        $adminRole = Role::create(['name'=> 'admin']);
        $adminUser->assignRole($adminRole);

    }
}
