<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Models\Carton;
use App\Models\Carton_serie;

class CartonsController extends Controller
{
    public function cartons(){

        $series = Carton::select(
            'cartons.context_id',
            'contexts.name',
            'contexts.mode',
            'contexts.is_with_letters',
            'contexts.rows',
            'contexts.columns',
            'cartons.carton_id',
            'cartons_series.carton_serie_id',
            'cartons_series.x_axis as x',
            'cartons_series.y_axis as y',
            'numbers.number',
            'letters.letter',
            DB::raw("CONCAT(letters.letter,numbers.number) AS serie")
        )
        ->join('contexts','contexts.context_id','cartons.context_id')
        ->join('cartons_series','cartons_series.carton_id','cartons.carton_id')
        ->join('series','series.serie_id','cartons_series.serie_id')
        ->join('letters','letters.letter_id','series.letter_id')
        ->join('numbers','numbers.number_id','series.number_id')
        ->orderBy('cartons.carton_id')
        ->orderBy('cartons_series.y_axis')
        ->orderBy('cartons_series.x_axis')
        ->distinct()
        ->get();

        $cartons = array();
        // foreach($series as $serie){
        //     if( !$serie->is_with_letters ){
        //         $cartons['mode'] = 'rows';
        //         $cartons[str_pad($serie->carton_id, 3, '0', STR_PAD_LEFT)][$serie->x][$serie->y] = $serie->number;
        //     }else{
        //         $cartons['mode'] = 'columns';
        //         $cartons[str_pad($serie->carton_id, 3, '0', STR_PAD_LEFT)][$serie->letter][$serie->x] = $serie->number;
        //     }
        // }
        foreach($series as $serie){
            if( empty($cartons[$serie->mode]) ) $cartons[$serie->mode] = [];

            if( empty($cartons[$serie->mode]['rows']) ) $cartons[$serie->mode]['rows'] = $serie->rows;
            if( empty($cartons[$serie->mode]['columns']) ) $cartons[$serie->mode]['columns'] = $serie->columns;

            $number_carton = str_pad($serie->carton_id, 3, '0', STR_PAD_LEFT);

            if( empty($cartons[$serie->mode]['cartons']) ) $cartons[$serie->mode]['cartons'] = [];
            
            if( !isset($cartons[$serie->mode]['cartons'][$number_carton]) )
                $cartons[$serie->mode]['cartons'][$number_carton] = [ $serie->letter => [] ];

        
            if( isset($cartons[$serie->mode]['cartons'][$number_carton][$serie->letter]) ){
                array_push($cartons[$serie->mode]['cartons'][$number_carton][$serie->letter],$serie->number);
            }else{
                $cartons[$serie->mode]['cartons'][$number_carton][$serie->letter] = [ $serie->number ];
            }

            // if( !$serie->is_with_letters ){
            //     $cartons['mode'] = 'rows';
            //     $cartons[str_pad($serie->carton_id, 3, '0', STR_PAD_LEFT)][$serie->x][$serie->y] = $serie->number;
            // }else{
            //     $cartons['mode'] = 'columns';
            //     $cartons[str_pad($serie->carton_id, 3, '0', STR_PAD_LEFT)][$serie->letter][$serie->x] = $serie->number;
            // }
            // $cartons[$serie->carton_id][$serie->y][$serie->x] = [ 'position' => $serie->x.','.$serie->y, 'number' => $serie->number ];

        }
        
        return response()->json($cartons)->getContent();

    }

    public function carton($number){

        $series = Carton::select(
            'cartons.context_id',
            'contexts.name',
            'contexts.is_with_letters',
            'cartons.carton_id',
            'cartons_series.carton_serie_id',
            'cartons_series.x_axis as x',
            'cartons_series.y_axis as y',
            'numbers.number',
            'letters.letter',
            DB::raw("CONCAT(letters.letter,numbers.number) AS serie")
        )
        ->join('contexts','contexts.context_id','cartons.context_id')
        ->join('cartons_series','cartons_series.carton_id','cartons.carton_id')
        ->join('series','series.serie_id','cartons_series.serie_id')
        ->join('letters','letters.letter_id','series.letter_id')
        ->join('numbers','numbers.number_id','series.number_id')
        ->where('cartons.carton_id',$number)
        ->orderBy('cartons_series.y_axis')
        ->orderBy('cartons_series.x_axis')
        ->distinct()
        ->get();

        $cartons = array();
        foreach($series as $serie){
            if( !$serie->is_with_letters ){
                $cartons['mode'] = 'rows';
                $cartons[str_pad($serie->carton_id, 3, '0', STR_PAD_LEFT)][$serie->x][$serie->y] = $serie->number;
            }else{
                $cartons['mode'] = 'columns';
                $cartons[str_pad($serie->carton_id, 3, '0', STR_PAD_LEFT)][$serie->letter][$serie->x] = $serie->number;
            }
        }
        
        return response()->json($cartons)->getContent();

    }
}
