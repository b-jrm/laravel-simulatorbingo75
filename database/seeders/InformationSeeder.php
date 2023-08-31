<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\City;
use App\Models\Country;
use App\Models\Document;
use App\Models\Information;

class InformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $document_id = Document::select('document_id')->where('code','CC')->first()->document_id;
        $city_id = City::select('city_id')
            ->where('name','Bogotá')
            ->where('country_id',Country::select('country_id')->where('name','Colombia')->first()->country_id)
            ->first()->city_id;

        $user_id = User::select('user_id')->where('email','system2023@web.co')->first()->user_id;
        Information::create([ 
            "user_id" => $user_id, "nickname" => "System", "firstname" => "System", "lastname" => "Default", 
            "document_id" => $document_id, "numberdocument" => "1010101010", "photo" => "default.png", "phone" => "1111111", 
            "mobile" => "1111111111", "address" => "web system", "birthdate" => "2023-06-13 16:30:00", "gender" => "I", 
            "language" => "es", "location_id" => null, "city_id" => $city_id
        ]);

        $user_id = User::select('user_id')->where('email','admin2023@web.co')->first()->user_id;
        Information::create([ 
            "user_id" => $user_id, "nickname" => "Admin", "firstname" => "Admin", "lastname" => "Default", 
            "document_id" => $document_id, "numberdocument" => "1212121212", "photo" => "default.png", "phone" => "2222222", 
            "mobile" => "2222222222", "address" => "web admin", "birthdate" => "2023-06-13 16:35:00", "gender" => "I", 
            "language" => "es", "location_id" => null, "city_id" => $city_id
        ]);

        $user_id = User::select('user_id')->where('email','player2023@web.co')->first()->user_id;
        Information::create([ 
            "user_id" => $user_id, "nickname" => "Player", "firstname" => "Player", "lastname" => "Default", 
            "document_id" => $document_id, "numberdocument" => "1313131313", "photo" => "default.png", "phone" => "3333333", 
            "mobile" => "3333333333", "address" => "web admin", "birthdate" => "2023-06-13 16:40:00", "gender" => "I", 
            "language" => "es", "location_id" => null, "city_id" => $city_id
        ]);

        unset(
            $user_id,
            $document_id,
            $city_id
        );
    }
}
