<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Board;
use App\Models\Context;

class BoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach( [ ['75 Balls',75, 'BINGO'], ['90 Balls',90, null] ] as $board ){

            $context = Context::where('name',$board[0])->first();

            if( !empty($context) )
                Board::create(['boxes' => $board[1], 'word' => $board[2], 'context_id' => $context->context_id]);
            
        }
    }
}
