<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Context;
use App\Models\Coordinate;

class CoordinateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * |--------------------------------------------------------------------------------------------
         * |    According to the existing contexts, the largest number 
         * |    of rows and columns is taken to guarantee that the necessary 
         * |    coordinates exist for the modes of each context, although not 
         * |    all the coordinates are used in each context.
         * |
         */
        for ($x=0; $x < Context::max('rows'); $x++) {
            for ($y=0; $y < Context::max('columns'); $y++) {
                Coordinate::create([ 'x' => $x, 'y' => $y ]);
            }
        }
    }
}
