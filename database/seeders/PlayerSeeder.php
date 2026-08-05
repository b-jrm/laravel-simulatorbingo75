<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Player;
use App\Models\Information;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Player Default System
        $user_id = User::select('user_id')->where('email','system2023@web.co')->first()->user_id;
        $information_id = Information::select('information_id')->where('user_id',$user_id)->first()->information_id;
        Player::create([ "information_id" => $information_id ]);

        // Player Default Admin
        $user_id = User::select('user_id')->where('email','admin2023@web.co')->first()->user_id;
        $information_id = Information::select('information_id')->where('user_id',$user_id)->first()->information_id;
        Player::create([ "information_id" => $information_id ]);

        // Player Default
        $user_id = User::select('user_id')->where('email','player2023@web.co')->first()->user_id;
        $information_id = Information::select('information_id')->where('user_id',$user_id)->first()->information_id;
        Player::create([ "information_id" => $information_id ]);

        unset(
            $user_id,
            $information_id
        );
    }
}
