<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $types = RoomType::all();
        // Create host factory with hotel
        return Hotel::factory(3)->create()->each(function ($hotel){
            Room::factory(rand(1,4))->create([
                'hotel_id' => $hotel->id,
                'room_type_id' => RoomType::all()->random()->id
            ]);
        });
    }
}
