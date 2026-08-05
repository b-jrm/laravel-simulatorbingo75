<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Mode;
use App\Models\Submode;

class SubmodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach( Mode::all() as $mode ){
            foreach( ($this->submodes($mode->name)?? []) as $submode ){
                Submode::create([ 'mode_id' => $mode->mode_id, 'name' => $submode ]);
            }
        }
    }

    // Submodes Default
    public function submodes(String $mode){
        $submodes = [
            'Lleno' => [
                'Lleno'
            ],
            'Diagonal' => [
                'Diagonal Derecha',
                'Diagonal Izquierda'
            ],
            'Horizontal' => [
                'Horizontal Superior', 
                'Horizontal Superior Secundario', 
                'Horizontal Central', 
                'Horizontal Inferior Secundario', 
                'Horizontal Inferior'
            ],
            'Vertical' => [
                'Vertical Izquierdo', 
                'Vertical Izquierdo Secundario', 
                'Vertical Central', 
                'Vertical Derecho Secundario', 
                'Vertical Derecho'
            ],
            'Numeros' => [
                'Forma 1',
                'Forma 2',
                'Forma 3',
                'Forma 4'
            ],
            'Letras' => [
                'Letra A',
                'Letra B',
                'Letra C',
                'Letra D'
            ],
        ];
        return $submodes[$mode];
    }
}
