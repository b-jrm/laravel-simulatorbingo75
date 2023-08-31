<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Department;
use App\Models\Country;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colombia_id = Country::where('name','Colombia')->first()->country_id;

        // Ciudades de Cundinamarca
        $cundinamarca = Department::where('name','Cundinamarca')->first();
        City::create([ "name" => "Bogotá", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Soacha", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Madrid", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Facatativá", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Fusagasugá", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Zipaquirá", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Chía", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Girardot", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Mosquera", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Funza", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Cajicá", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Ubaté", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Guaduas", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Sibaté", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "La Mesa", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Pacho", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Tocancipá", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Villeta", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "La Calera", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Sopó", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Silvania", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Tabio", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "El Colegio", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Cota", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Chocontá", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Cogua", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Tenjo", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Villapinzón", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Tocaima", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Cáqueza", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Yacopí", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Puerto Salgar", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Nilo", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Suesca", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Caparrapí", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "El Rosal", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Viotá", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "La Vega", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Subachoque", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Anolaima", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Guasca", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Fómeque", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Ubalá", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Agua de Dios", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Arbeláez", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Anapoima", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Guachetá", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Nemocón", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Pasca", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Choachí", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Simijaca", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Gachancipá", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "San Antonio del Tequendama", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Gachetá", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Sasaima", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "San Bernardo", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Susa", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Cachipay", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Sesquilé", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Lenguazaque", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Medina", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "San Juan de Rioseco", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "La Palma", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Bojacá", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Carmen de Carupa", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Chipaque", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "San Francisco", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Junín", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Ricaurte", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Quipile", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Une", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Apulo", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Tena", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Vergara", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Paratebueno", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Granada", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "La Peña", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Cucunubá", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Ubaque", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Machetá", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Fosca", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Quetame", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Albán", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Gachalá", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Guatavita", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Nimaima", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Pandi", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Nocaima", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Paime", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "San Cayetano", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Fúquene", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Zipacón", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "El Peñón", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Supatá", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Tibacuy", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Sutatausa", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Tausa", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Guayabetal", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Topaipí", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Cabrera", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Quebradanegra", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Manta", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Útica", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Vianí", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Chaguaní", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Venecia", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Gama", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Guayabal de Síquima", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Gutiérrez", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Tibirita", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Jerusalén", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Bituima", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Guataquí", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Villagómez", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Nariño", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        City::create([ "name" => "Beltrán", "department_id" => $cundinamarca->department_id, "country_id" => $colombia_id ]);
        unset($cundinamarca);

        // Ciudades de Amazonas
        $amazonas = Department::where('name','Amazonas')->first();
        City::create([ "name" => "Leticia", "department_id" => $amazonas->department_id, "country_id" => $colombia_id ]);
        unset($amazonas);

        // Ciudades de Antioquia
        $antioquia = Department::where('name','Antioquia')->first();
        City::create([ "name" => "Medellín", "department_id" => $antioquia->department_id, "country_id" => $colombia_id ]);
        unset($antioquia);

        // Ciudades de Arauca
        $arauca = Department::where('name','Arauca')->first();
        City::create([ "name" => "Arauca", "department_id" => $arauca->department_id, "country_id" => $colombia_id ]);
        unset($arauca);

        // Ciudades de Atlántico
        $atlantico = Department::where('name','Atlántico')->first();
        City::create([ "name" => "Barranquilla", "department_id" => $atlantico->department_id, "country_id" => $colombia_id ]);
        unset($atlantico);

        // Ciudades de Bolívar
        $bolivar = Department::where('name','Bolívar')->first();
        City::create([ "name" => "Cartagena de Indias", "department_id" => $bolivar->department_id, "country_id" => $colombia_id ]);
        unset($bolivar);

        // Ciudades de Boyacá
        $boyaca = Department::where('name','Boyacá')->first();
        City::create([ "name" => "Tunja", "department_id" => $boyaca->department_id, "country_id" => $colombia_id ]);
        unset($boyaca);

        unset($colombia_id);
    }
}
