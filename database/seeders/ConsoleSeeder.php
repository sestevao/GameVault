<?php

namespace Database\Seeders;

use App\Models\Console;
use App\Models\ConsoleOwner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConsoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $consoleOwners = [
            ['id' => 1, 'name' => 'Sony', 'image' => '/images/consoles/sony.jpg', 'cover' => '/images/consoles/sony_background.jpg'],
            ['id' => 2, 'name' => 'Microsoft', 'image' => '/images/consoles/microsoft.jpg', 'cover' => '/images/consoles/microsoft_background.jpg'],
            ['id' => 3, 'name' => 'Nintendo', 'image' => '/images/consoles/nintendo.png', 'cover' => '/images/consoles/nintendo_background.jpg'],
            ['id' => 4, 'name' => 'Sega', 'image' => null, 'cover' => null],
        ];

        foreach ($consoleOwners as $owner) {
            $consoleOwner = ConsoleOwner::create($owner);

            $consoles = [
                ['name' => 'PS5', 'image' => '/images/consoles/ps5.jpg', 'owner_id' => $consoleOwner->id],
                ['name' => 'PS4', 'image' => '/images/consoles/ps4.jpg', 'owner_id' => $consoleOwner->id],
                ['name' => 'PS3', 'image' => '/images/consoles/ps3.jpg', 'owner_id' => $consoleOwner->id],
                ['name' => 'PS2', 'image' => '/images/consoles/ps2.jpg', 'owner_id' => $consoleOwner->id],
                ['name' => 'Xbox', 'image' => '/images/consoles/xbox.svg', 'owner_id' => $consoleOwner->id],
                ['name' => 'Switch', 'image' => '/images/consoles/switch.svg', 'owner_id' => $consoleOwner->id],
                ['name' => 'WiiU', 'image' => '/images/consoles/wiiu.png', 'owner_id' => $consoleOwner->id],
                ['name' => 'Wii', 'image' => '/images/consoles/wii.jpg', 'owner_id' => $consoleOwner->id],
            ];

            foreach ($consoles as $console) {
                Console::create($console);
            }
        }

    }
}
