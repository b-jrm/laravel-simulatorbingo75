<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([ "email" => "system2023@web.co", "password" => Hash::make('system2023') ]);
        User::create([ "email" => "admin2023@web.co", "password" => Hash::make('admin2023') ]);
        User::create([ "email" => "player2023@web.co", "password" => Hash::make('player2023') ]);
    }
}
