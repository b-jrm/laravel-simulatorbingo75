<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

use App\Models\Continent;

class ContinentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('continents')->insert([
        //     'name' => Str::random(10),
        //     'status' => 1,
        // ]);
        Continent::create(["name" => "Ásia"]);
        Continent::create(["name" => "América"]);
        Continent::create(["name" => "África"]);
        Continent::create(["name" => "Antártida"]);
        Continent::create(["name" => "Europa"]);
        Continent::create(["name" => "Oceanía"]);

    }
}
