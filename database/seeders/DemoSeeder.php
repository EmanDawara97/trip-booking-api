<?php

namespace Database\Seeders;

use App\Enums\TripType;
use App\Models\City;
use App\Models\Trip;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $damascus = City::create(['name' => 'Damascus']);
        $latakia = City::create(['name' => 'Latakia']);

        foreach ([TripType::Regular, TripType::Vip] as $type) {
            $trip = Trip::create([
                'origin_city_id' => $damascus->id,
                'destination_city_id' => $latakia->id,
                'departure_at' => now()->addDays(2),
                'type' => $type,
                'base_price' => 10000,
            ]);

            foreach (range(1, 10) as $n) {
                $trip->seats()->create(['seat_number' => $n]);
            }
        }
    }
}