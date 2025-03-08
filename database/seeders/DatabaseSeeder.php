<?php

namespace Database\Seeders;

use App\Models\Console;
use App\Models\Game;
use App\Models\Genre;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        if(Console::count() === 0) {
            $this->call([
                ConsoleSeeder::class,
            ]);
        }

        if(Genre::count() === 0) {
            $this->call([
                GenreSeeder::class,
            ]);
        }

        if(Game::count() === 0) {
            $this->call([
                GameSeeder::class,
            ]);
        }

    }
}
