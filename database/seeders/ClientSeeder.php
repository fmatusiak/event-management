<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        for ($i = 0; $i < 100; $i++) {
            Client::create([
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName,
                'pesel' => fake()->unique()->numerify('###########'),
                'email' => fake()->unique()->safeEmail,
                'phone' => fake()->phoneNumber,
            ]);
        }
    }
}
