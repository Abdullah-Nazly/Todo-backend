<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Todo;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a fixed test user
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'], // look for existing user
            ['name' => 'Test User', 'password' => Hash::make('password')]
        );

        // Create 10 todos for that user
        Todo::factory()->count(10)->create([
            'user_id' => $user->id,
        ]);

        // Optional: create more random users with their todos
        User::factory(5)->create()->each(function ($user) {
            Todo::factory()->count(5)->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
