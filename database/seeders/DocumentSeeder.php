<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Document;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Document::create([ "code" => "CC", "name" => "Cédula" ]);
        Document::create([ "code" => "CE", "name" => "Cédula de Extranjería" ]);
        Document::create([ "code" => "NIT", "name" => "Número de Identificación Tributaria" ]);
        Document::create([ "code" => "NUIP", "name" => "Número Único de Identificación Personal" ]);
        Document::create([ "code" => "PAP", "name" => "Pasaporte" ]);
        Document::create([ "code" => "TI", "name" => "Tarjeta de identidad" ]);
        Document::create([ "code" => "NIF", "name" => "Número de Identificación Fiscal" ]);
        
        Document::create([ "code" => "NIE", "name" => "Número de Identificación de Extranjería" ]);
        Document::create([ "code" => "DNI", "name" => "Documento de Identidad" ]);
        Document::create([ "code" => "DNIe", "name" => "Documento de Identidad Electrónico" ]);
    }
}
