<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

use App\Models\Serie;
use App\Models\Board;
use App\Models\Context;
use App\Models\Board_serie;

class BoardSerieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $boards = Board::select(
                    'boards.board_id',
                    'boards.boxes',
                    'boards.word',
                    'contexts.context_id',
                    'contexts.columns AS columns_context',
                    // DB::raw('(boards.boxes/contexts.columns) AS rows'),
                    'contexts.is_with_letters'
                )
                ->join('contexts','contexts.context_id','boards.context_id')
                ->get();

        foreach( $boards as $board ){

            $board->rows = $board->columns_context;
            $board->columns = ($board->boxes/$board->columns_context);

            // Default Board 75 Balls
            if( $board->is_with_letters && strlen($board->word) ){

                $box = 1;
                while ($box < $board->boxes) {

                    for ($row=0; $row < $board->rows; $row++) {

                        for ($col=0; $col < $board->columns; $col++) {

                            $serie = Serie::select(
                                'series.serie_id',
                                'letters.letter',
                                'numbers.number'
                            )
                            ->join('letters','letters.letter_id','series.letter_id')
                            ->join('numbers','numbers.number_id','series.number_id')
                            ->where('letters.letter',$board->word[$row])
                            ->where('numbers.number',$box)
                            ->first();
                            if( !empty($serie) ){
                                Board_serie::create([ 'board_id' => $board->board_id, 'serie_id' => $serie->serie_id ]);
                                $box++;
                            }

                        }

                    }

                    $box++;

                }
                
            }
            // Code Board Different 75 Balls
            else{
                
            }
            
        }
    }
}
