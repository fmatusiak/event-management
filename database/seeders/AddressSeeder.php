<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) {
            Address::create([
                'street' => fake()->streetName,
                'city' => fake()->city,
                'postcode' => fake()->postcode,
                'latitude' => fake()->latitude,
                'longitude' => fake()->longitude,
            ]);
        }
    }
}
