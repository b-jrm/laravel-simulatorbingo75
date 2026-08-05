<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Roll;
use App\Models\User_roll;

class UserRollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $system_user_id = User::select('user_id')->where('email','system2023@web.co')->first()->user_id;
        $admin_user_id = User::select('user_id')->where('email','admin2023@web.co')->first()->user_id;
        $player_user_id = User::select('user_id')->where('email','player2023@web.co')->first()->user_id;

        $system_roll_id = Roll::select('roll_id')->where('name','system')->first()->roll_id;
        $admin_roll_id = Roll::select('roll_id')->where('name','administrator')->first()->roll_id;
        $player_roll_id = Roll::select('roll_id')->where('name','player')->first()->roll_id;

        /** User System Default All Rolls */
        User_roll::create([ "user_id" => $system_user_id, "roll_id" => $system_roll_id ]);
        User_roll::create([ "user_id" => $system_user_id, "roll_id" => $admin_user_id ]);
        User_roll::create([ "user_id" => $system_user_id, "roll_id" => $player_user_id ]);

        /** User Admin Default Rolls (Admin,Player) */
        User_roll::create([ "user_id" => $admin_user_id, "roll_id" => $admin_roll_id ]);
        User_roll::create([ "user_id" => $admin_user_id, "roll_id" => $player_roll_id ]);

        /** User Player Default Rolls (Player) */
        User_roll::create([ "user_id" => $player_roll_id, "roll_id" => $player_roll_id ]);

        unset(
            $system_user_id, 
            $system_roll_id, 
            $admin_user_id, 
            $admin_roll_id, 
            $player_user_id, 
            $player_roll_id
        );
    }
}
