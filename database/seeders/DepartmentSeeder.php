<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Country;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colombia = Country::where('name','Colombia')->first();
        // Departamentos de colombia
        Department::create([ "name" => "Amazonas", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Antioquia", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Arauca", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Atlántico", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Bolívar", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Boyacá", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Caldas", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Caquetá", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Casanare", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Cauca", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Cesar", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Chocó", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Córdoba", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Cundinamarca", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Guainía", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Guaviare", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Huila", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "La Guajira", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Magdalena", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Meta", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Nariño", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Norte de Santander", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Putumayo", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Quindío", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Risaralda", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "San Andrés y Providencia", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Santander", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Sucre", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Tolima", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Valle del Cauca", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Vaupés", "country_id" => $colombia->country_id ]);
        Department::create([ "name" => "Vichada", "country_id" => $colombia->country_id ]);

        unset($colombia);
    }
}
