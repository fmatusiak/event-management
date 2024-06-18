<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('login', 'admin')->first();

        if (!$user) {
            DB::table('users')->insert([
                'login' => 'admin',
                'password' => '$2y$12$/vOwoXmbbbmyC0uYM4c5KeNhjus2bZpH4dqWfAQq6m5uFs3YQFZo.',
            ]);
        }
    }
}
