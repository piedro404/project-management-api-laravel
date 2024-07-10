<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\User::factory(2)->create();

        \App\Models\User::factory()->create([
            'name' => 'pedro',
            'email' => 'pedro@gmail.com',
            'password' => bcrypt('admin'),
        ]);

        \App\Models\Project::factory(5)->create();

        \App\Models\Task::factory(50)->create();
    }
}
