<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CitySeeder;
use Database\Seeders\RoomTypeSeeder;
use Database\Seeders\HotelSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        return $this->call([
            CitySeeder::class,
            RoomTypeSeeder::class,
            HotelSeeder::class,
        ]);
    }
}
