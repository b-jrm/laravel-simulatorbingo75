<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Serie;
use App\Models\Letter;
use App\Models\Number;

class SerieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Default Bingo 75 Balls
        $seventy_five_balls = [
            'B' => [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15 ],
            'I' => [ 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30 ],
            'N' => [ 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 0 ], // 0 = Center Carton
            'G' => [ 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60 ],
            'O' => [ 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75 ]
        ];

        foreach ($seventy_five_balls as $letter => $numbers) {
            $letter_id = Letter::select('letter_id')->where('letter',$letter)->first()->letter_id;

            foreach ($numbers as $number) {
                $number_id = Number::select('number_id')->where('number',$number)->first()->number_id;
                Serie::create([ "letter_id" => $letter_id, "number_id" => $number_id ]);
            }
        }

        // Default Bingo 90 Balls
        $ninety_five_balls = [
            [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ],
            [ 11, 12, 13, 14, 15, 16, 17, 18, 19, 20 ],
            [ 21, 22, 23, 24, 25, 26, 27, 28, 29, 30 ],
            [ 31, 32, 33, 34, 35, 36, 37, 38, 39, 40 ],
            [ 41, 42, 43, 44, 45, 46, 47, 48, 49, 50 ],
            [ 51, 52, 53, 54, 55, 56, 57, 58, 59, 60 ],
            [ 61, 62, 63, 64, 65, 66, 67, 68, 69, 70 ],
            [ 71, 72, 73, 74, 75, 76, 77, 78, 79, 80 ],
            [ 81, 82, 83, 84, 85, 86, 87, 88, 89, 90 ]
        ];

        foreach ($ninety_five_balls as $numbers) {
            foreach ($numbers as $number) {
                $number_id = Number::select('number_id')->where('number',$number)->first()->number_id;
                Serie::create([ "number_id" => $number_id ]);
            }
        }

    }
}
