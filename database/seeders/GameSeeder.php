<?php

namespace Database\Seeders;

use App\Models\Console;
use App\Models\Game;
use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ps5 = Console::where('name', 'PS5')->first();
        $ps4 = Console::where('name', 'PS4')->first();
        $xbox = Console::where('name', 'Xbox')->first();

        $actionGenre = Genre::where('name', 'Action')->first();
        $shooterGenre = Genre::where('name', 'Shooter')->first();
        $fpsGenre = Genre::where('name', 'First-person shooter')->first();
        $actionAdventureGenre = Genre::where('name', 'Action-Adventure')->first();
        $adventureGenre = Genre::where('name', 'Adventure')->first();

        $games = [
            [
                'title' => 'Assassin\'s Creed Odyssey',
                'cover' => '/images/games/assassins-creed-odyssey-ps4.png',
                'console_id' => $ps4->id,
                'genre_id' => $actionGenre->id,
                'notes' => 'Great graphics!',
            ],
            [
                'title' => 'God of War Ragnarok',
                'cover' => '/images/games/god-of-war-ragnaroek-ps4.png',
                'console_id' => $ps4->id,
                'genre_id' => $adventureGenre->id,
                'notes' => 'Great graphics!',
            ],
            [
                'title' => 'Destiny 2',
                'cover' => '/images/games/destiny2_ps4.png',
                'console_id' => $ps4->id,
                'genre_id' => $fpsGenre->id,
                'notes' => 'Great graphics!',
            ],
            [
                'title' => 'The Last of Us Part II',
                'cover' => '/images/games/The-Last-of-Us-Part-II-(PS4).png',
                'console_id' => $ps4->id,
                'genre_id' => $actionAdventureGenre->id,
                'notes' => 'Emotional and engaging storyline.',
            ],
            [
                'title' => 'Halo Infinite',
                'cover_id' => '/images/games/halo-infinite-xbox-one.jpg',
                'console_id' => $xbox->id,
                'genre_id' => $shooterGenre->id,
                'notes' => 'Great multiplayer experience.',
            ],
        ];

        foreach ($games as $game) {
            Game::create($game);
        }
    }
}
