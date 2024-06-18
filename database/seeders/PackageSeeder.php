<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => '1 godzinny',
                'rental_time' => 60,
                'price' => 599
            ],
            [
                'name' => '2 godzinny',
                'rental_time' => 120,
                'price' => 999
            ],
            [
                'name' => '3 godzinny',
                'rental_time' => 180,
                'price' => 1299
            ],
            [
                'name' => '4 godzinny',
                'rental_time' => 240,
                'price' => 1499
            ]
        ];

        foreach ($packages as $package) {
            Package::updateOrCreate($package);
        }
    }
}
