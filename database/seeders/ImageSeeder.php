<?php

namespace Database\Seeders;

use App\Models\Console;
use App\Models\Game;
use App\Models\Genre;
use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = [
            [ 'file_path' => '/images/consoles/sony.jpg', 'file_name' => 'sony.jpg', 'mime' => 'image/jpg' ],
            [ 'file_path' => '/images/consoles/sony_background.jpg',"file_name" => 'sony_background.jpg', 'image/jpg' ],
            [ 'file_path' => '/images/consoles/microsoft.jpg',"file_name" => 'microsoft.jpg', 'image/jpg' ],
            [ 'file_path' => '/images/consoles/microsoft_background.jpg', "file_name" => 'microsoft_background.jpg', 'image/jpg'],
            [ 'file_path' => '/images/consoles/nintendo.png',"file_name" => 'nintendo.png', 'image/png' ],
            [ 'file_path' => '/images/consoles/nintendo_background.jpg',"file_name" => 'nintendo_background.jpg', 'image/jpg' ],
            [ 'file_path' => '/images/consoles/ps5.jpg', "file_name" => 'ps5.jpg', 'mime' => 'image/jpg' ],
            [ 'file_path' => '/images/consoles/ps4.jpg', "file_name" => 'ps4.jpg', 'mime' => 'image/jpg' ],
            [ 'file_path' => '/images/consoles/ps3.jpg', "file_name" => 'ps3.jpg', 'mime' => 'image/jpg' ],
            [ 'file_path' => '/images/consoles/ps2.jpg', "file_name" => 'ps2.jpg', 'mime' => 'image/jpg' ],
            [ 'file_path' => '/images/consoles/xbox.svg', "file_name" => 'xbox.svg', 'mime' => 'image/svg', ],
            [ 'file_path' => '/images/consoles/switch.svg', "file_name" => 'switch.svg', 'mime' => 'image/svg', ],
            [ 'file_path' => '/images/consoles/wiiu.png', "file_name" => 'wiiu.png', 'mime' => 'image/jpg', ],
            [ 'file_path' => '/images/consoles/wii.jpg', "file_name" => 'wii.jpg', 'mime' => 'image/jpg' ],
            [ 'file_path' => '/images/games/assassins-creed-odyssey-ps4.png',"file_name" => 'assassins-creed-odyssey-ps4.png', 'image/png' ],
            [ 'file_path' => '/images/games/god-of-war-ragnaroek-ps4.png',"file_name" => 'god-of-war-ragnaroek-ps4.png', 'image/png' ],
            [ 'file_path' => '/images/games/destiny2_ps4.png',"file_name" => 'destiny2_ps4.png', 'image/png' ],
            [ 'file_path' => '/images/games/The-Last-of-Us-Part-II-(PS4).png',"file_name" => 'The-Last-of-Us-Part-II-(PS4).png', 'image/png' ],
            [ 'file_path' => '/images/games/halo-infinite-xbox-one.jpg',"file_name" => 'halo-infinite-xbox-one.jpg', 'image/jpg' ],
        ];

        foreach ($images as $image) {
            Image::create($image);
        }
    }
}
