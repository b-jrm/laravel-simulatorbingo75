<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

use App\Models\Carton;
use App\Models\Serie;
use App\Models\Context;
use App\Models\Carton_serie;

class CartonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Default Cartons
        foreach ($this->cartons() as $context => $cartons) { 
            $context = Context::where('name',$context)->first();
            if( is_numeric($context->context_id) ){

                foreach ($cartons as $carton) {
                
                    $pos_y = 0;

                    $newcarton = Carton::create([ "context_id" => $context->context_id ]);

                    foreach($carton as $letter => $numbers){

                        if( $context->is_with_letters && !is_numeric($letter) ){
                            foreach($numbers as $pos_x => $number){
                                if( $pos_y <= ($context->columns - 1) && $pos_x <= ($context->rows - 1) ){
                                    $serie = Serie::select('series.serie_id', DB::raw("CONCAT(letters.letter,numbers.number) AS serie") )
                                        ->join('numbers', 'numbers.number_id', 'series.number_id')
                                        ->join('letters', 'letters.letter_id', 'series.letter_id')
                                        ->where('numbers.number',$number)
                                        ->where('letters.letter',$letter)
                                        ->first();
                                    
                                    if( !empty($serie) && is_numeric($serie->serie_id) ){

                                        if( !Carton_serie::where('carton_id', $newcarton->carton_id)->where('serie_id', $serie->serie_id)->exists() ){
                                            Carton_serie::create([
                                                'carton_id' => $newcarton->carton_id,
                                                'serie_id' => $serie->serie_id,
                                                'x_axis' => $pos_x,
                                                'y_axis' => $pos_y
                                            ]);
                                        }
                                        
                                    }
                                }
                            }

                            $pos_y++;
                        }else break;

                    }
                    
                }

            }else break;
        }

    }


    public function cartons(){

        return [
            '75 Balls' => [
                [ 
                    'B' => [ 7, 2, 11, 1, 6 ],
                    'I' => [ 17, 22, 20, 18, 16 ],
                    'N' => [ 34, 40, 0, 45, 33 ],
                    'G' => [ 54, 59, 47, 60, 58 ],
                    'O' => [ 61, 67, 72, 63, 75 ]
                ],
                [ 
                    'B' => [ 8, 9, 14, 10, 15 ],
                    'I' => [ 28, 19, 22, 20, 18 ],
                    'N' => [ 31, 36, 0, 39, 37 ],
                    'G' => [ 50, 48, 46, 57, 54 ],
                    'O' => [ 75, 73, 63, 74, 64 ]          
                ],
                [ 
                    'B' => [ 11, 2, 12, 3, 1 ],
                    'I' => [ 21, 17, 30, 27, 25 ],
                    'N' => [ 44, 34, 0, 32, 35 ],
                    'G' => [ 48, 46, 51, 47, 52 ],
                    'O' => [ 65, 71, 74, 64, 62 ]          
                ],
                [ 
                    'B' => [ 12, 10, 8, 13, 1 ],
                    'I' => [ 22, 19, 17, 28, 26 ],
                    'N' => [ 31, 44, 0, 40, 38 ],
                    'G' => [ 49, 54, 52, 50, 60 ],
                    'O' => [ 73, 71, 62, 72, 70 ]          
                ],
                [ 
                    'B' => [ 13, 3, 1, 4, 10 ],
                    'I' => [ 23, 28, 24, 29, 27 ],
                    'N' => [ 32, 43, 0, 41, 31 ],
                    'G' => [ 50, 47, 60, 51, 54 ],
                    'O' => [ 61, 72, 63, 73, 71 ]          
                ],
                [ 
                    'B' => [ 8, 11, 9, 5, 10 ],
                    'I' => [ 23, 29, 17, 30, 20 ],
                    'N' => [ 38, 44, 0, 42, 32 ],
                    'G' => [ 58, 56, 53, 49, 47 ],
                    'O' => [ 68, 65, 61, 67, 64 ]          
                ]
            ],
            '90 Balls' => [
                
            ]
        ];

    }

}
