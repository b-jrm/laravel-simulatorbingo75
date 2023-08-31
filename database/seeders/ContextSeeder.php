<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Context;

class ContextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Default Contexts
        Context::create([ "name" => '75 Balls', "mode" => 'V', "rows" => 5, "columns" => 5, "is_with_letters" => 1 ]);
        Context::create([ "name" => '90 Balls', "mode" => 'H', "rows" => 3, "columns" => 9, "is_with_letters" => 0 ]);
    }
}
