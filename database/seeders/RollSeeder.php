<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Roll;

class RollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Los permisos se definen con una inicial, 
         * 
         * Los permisos se le asignan a los roles, 
         * por lo que todos los usuarios que tengan un rol asignado, 
         * tendra los permisos de dicho rol
         * 
         * Permisos por defecto:
         * (p) => play (Puede Jugar)
         * (m) => manager (Puede Administrar)
         * (*) => para todos los permisos
         * 
         * Cada rol puede tener 1 o varios permisos concatenados con el caracter (:)         
         */

        Roll::create([ "name" => "system", "permissions" => "*" ]);
        Roll::create([ "name" => "administrator", "permissions" => "m:p" ]);
        Roll::create([ "name" => "player", "permissions" => "p" ]);
    }
}
