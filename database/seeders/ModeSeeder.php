<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Mode;
use App\Models\Context;

class ModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $context_id = Context::where('name','75 Balls')->first()->context_id;
        if( is_numeric($context_id) ){
            foreach( ['Lleno', 'Diagonal', 'Horizontal', 'Vertical', 'Numeros', 'Letras'] as $mode ){
                Mode::create([ 'context_id' => $context_id, 'name' => $mode ]);
            }
        }
    }
    
    // Coordinates Default: Example For Bingo 75 Balls => $this->coordinates(5,5,'V')
    public function coordinates( Int $rows = 0, Int $columns = 0, String $mode = 'V' ){
        $coords = array();

        for ($x=0; $x < $rows; $x++) {
            for ($y=0; $y < $columns; $y++) {
                array_push($coords, ( ($mode === 'H') ? [ 'x' => $y, 'y' => $x ] : [ 'x' => $x, 'y' => $y ] ) );
            }
        }

        return $coords;
    }
}
