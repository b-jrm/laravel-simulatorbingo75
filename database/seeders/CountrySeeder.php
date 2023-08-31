<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Continent;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $america = Continent::where('name','América')->first();

        // El caribe (America)
        Country::create([ "name" => "Antigua y Barbuda", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Aruba", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Bahamas", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Barbados", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Cuba", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Dominica", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Grenada", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Guadalupe", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Haití", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Islas Caimán", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Islas Turcas y Caicos", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Islas Vírgenes", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Jamaica", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Martinica", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Puerto Rico", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "República Dominicana", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "San Bartolomé", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "San Cristóbal y Nieves", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "San Vicente y las Granadinas", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Santa Lucía", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Trinidad y Tobago", "continent_id" => $america->continent_id ]);

        // America del sur
        Country::create([ "name" => "Argentina", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Bolivia", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Brasil", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Chile", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Colombia", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Ecuador", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Guyana", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Guyana Francesa", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Paraguay", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Perú", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Suriname", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Uruguay", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Venezuela", "continent_id" => $america->continent_id ]);

        // America central
        Country::create([ "name" => "Belice", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Costa Rica", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "El Salvador", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Guatemala", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Honduras", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Nicaragua", "continent_id" => $america->continent_id ]);
        Country::create([ "name" => "Panamá", "continent_id" => $america->continent_id ]);

        // America del norte
        Country::create([ "name" => "México", "continent_id" => $america->continent_id ]);
        unset($america);

        // Europa
        $europa = Continent::where('name','Europa')->first();

        // Paises (Europa)
        Country::create([ "name" => "Rusia", "continent_id" => $europa->continent_id ]);
        Country::create([ "name" => "Alemania", "continent_id" => $europa->continent_id ]);
        Country::create([ "name" => "Reino Unido", "continent_id" => $europa->continent_id ]);
        Country::create([ "name" => "Francia", "continent_id" => $europa->continent_id ]);
        Country::create([ "name" => "Italia", "continent_id" => $europa->continent_id ]);
        Country::create([ "name" => "España", "continent_id" => $europa->continent_id ]);
        Country::create([ "name" => "Ucrania", "continent_id" => $europa->continent_id ]);
        Country::create([ "name" => "Polonia", "continent_id" => $europa->continent_id ]);
        Country::create([ "name" => "Rumania", "continent_id" => $europa->continent_id ]);
        Country::create([ "name" => "Países Bajos", "continent_id" => $europa->continent_id ]);
 
    }
}
