<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->truncateTable([
            'rolls',
            'users',
            'users_rolls',
            'documents',
            'continents',
            'countries',
            'departments',
            'cities',
            'locations',
            'countries_documents',
            'informations',
            'players',
            'contexts',
            'numbers',
            'letters',
            'series',
            'cartons',
            'cartons_series',
            'coordinates',
            'modes',
            'submodes',
            'submodes_coordinates',
            'boards',
            'boards_series'
        ]);

        $this->call([
            RollSeeder::class,
            UserSeeder::class,
            UserRollSeeder::class,
            DocumentSeeder::class,
            ContinentSeeder::class,
            CountrySeeder::class,
            DepartmentSeeder::class,
            CitySeeder::class,
            LocationSeeder::class,
            CountryDocumentSeeder::class,
            InformationSeeder::class,
            PlayerSeeder::class,
            ContextSeeder::class,
            NumberSeeder::class,
            LetterSeeder::class,
            SerieSeeder::class,
            CartonSeeder::class,
            CoordinateSeeder::class,
            ModeSeeder::class,
            SubmodeSeeder::class,
            SubmodeCoordinateSeeder::class,
            BoardSeeder::class,
            BoardSerieSeeder::class
        ]);


    }

    function truncateTable(array $tables){

    	DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

    	foreach ($tables as $table) {
    		//Vaciar la tabla de los registros que tenga
    		DB::table($table)->truncate();
    	}
    	//Activa la revisión de llaves foraneas
    	DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }

}
