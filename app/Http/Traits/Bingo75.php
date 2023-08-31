<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Carton;
use App\Models\Carton_serie;

trait Bingo75 {
    public static $board = array(
        'B' => [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15 ],
        'I' => [ 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30 ],
        'N' => [ 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45 ],
        'G' => [ 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60 ],
        'O' => [ 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75 ]
    );
    
    public static function init ()
    {

    }

    public static function ranks(){
        $ranks = array();
        foreach( self::$board as $numbers ){
            foreach( $numbers as $number ){
                array_push($ranks, $number);
            }
        }
        return $ranks;
    }

    public static function board()
    {
        $board = array();
        foreach( self::$board as $key => $numbers )
        {
            $obj = new \stdClass;
            $obj->numbers = [];
            foreach( $numbers as $number ){
                array_push($obj->numbers,['number' => $number, 'active' => false]);
            }
            if( count($obj->numbers) ){
                array_push(
                    $board, 
                    (!is_numeric($key) ? [ 'letter' => $key, 'ranges' => $obj->numbers ] : [ 'ranges' => $obj->numbers ] )
                );
            }
        }
        return $board;
    }

    public static function cartons(Int $count = 1, Bool $selectable = false)
    {
        $cartons = new \stdClass;

        $letters = [ 'B', 'I', 'N', 'G', 'O' ];

        $numbers = array();

        for ($c=1; $c <= $count; $c++) { 
            $carton = new \stdClass;
            $number = str_pad(rand(1, 1000), 4, '0', STR_PAD_LEFT);

            while( in_array($number,$numbers) ){
                $number = str_pad(rand(1, 1000), 4, '0', STR_PAD_LEFT);
            }

            for ($column = 0; $column < 5; $column++) { 
                $row = 0;
                $series = [];
                while(count($series) < 5) { 
                    $serie = self::$board[$letters[$column]][array_rand(self::$board[$letters[$column]],1)];
                    if(!in_array($serie, array_column($series,'number')) ){
                        array_push($series, 
                            [
                                'number' => ( ($column == 2 && $row == 2) ? 0 : $serie ),
                                'coord' => [ 'x' => $column, 'y' => $row ], // Mode Read Vertical (X,Y) => (X = columns, Y = rows)
                                'active' => false,
                                'is_win' => false
                            ]
                        );
                        $row++;
                    }
                }
                $carton->series[$letters[$column]] = $series;
            }
            $cartons->$number = $carton->series;
        }
        return $cartons;
    }

}