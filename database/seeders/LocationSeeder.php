<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\City;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bogota = City::where('name','Bogotá')->first();
        Location::create([ "name" => "Usaquén", "city_id" => $bogota->city_id ]);
        Location::create([ "name" => "Chapinero", "city_id" => $bogota->city_id ]);
        Location::create([ "name" => "Santa fé", "city_id" => $bogota->city_id ]);
        Location::create([ "name" => "San cristobal", "city_id" => $bogota->city_id ]);
        Location::create([ "name" => "Usme", "city_id" => $bogota->city_id ]);
        Location::create([ "name" => "Tunjuelito", "city_id" => $bogota->city_id ]);
        Location::create([ "name" => "Bosa", "city_id" => $bogota->city_id ]);
        Location::create([ "name" => "Kennedy", "city_id" => $bogota->city_id ]);
        Location::create([ "name" => "Fontibón", "city_id" => $bogota->city_id ]);
        Location::create([ "name" => "Engativa", "city_id" => $bogota->city_id ]);
        Location::create([ "name" => "Suba", "city_id" => $bogota->city_id ]);
        Location::create([ "name" => "Barrios Unidos", "city_id" => $bogota->city_id ]);
        Location::create([ "name" => "Teusaquillo", "city_id" => $bogota->city_id ]);
        Location::create([ "name" => "Los Mártires", "city_id" => $bogota->city_id ]);
        Location::create([ "name" => "Antonio Nariño", "city_id" => $bogota->city_id ]);
        Location::create([ "name" => "Puente Aranda", "city_id" => $bogota->city_id ]);
        Location::create([ "name" => "La Candelaria", "city_id" => $bogota->city_id ]);
        Location::create([ "name" => "Rafael Uribe Uribe", "city_id" => $bogota->city_id ]);
        Location::create([ "name" => "Ciudad Bolívar", "city_id" => $bogota->city_id ]);
        Location::create([ "name" => "Sumapaz", "city_id" => $bogota->city_id ]);
        unset($bogotá);

    }
}
