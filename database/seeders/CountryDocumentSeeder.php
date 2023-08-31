<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Document;
use App\Models\Country;
use App\Models\Country_document;

class CountryDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Colombia
        $country_id = Country::where('name','Colombia')->first()->country_id;

        // Documentos de Colombia
        $cc = Document::select('document_id')->where('code','CC')->first();
        Country_document::create([ "document_id" => $cc->document_id, "country_id" => $country_id ]);
        $ce = Document::select('document_id')->where('code','CE')->first();
        Country_document::create([ "document_id" => $ce->document_id, "country_id" => $country_id ]);
        $nit = Document::select('document_id')->where('code','NIT')->first();
        Country_document::create([ "document_id" => $nit->document_id, "country_id" => $country_id ]);
        $nuip = Document::select('document_id')->where('code','NUIP')->first();
        Country_document::create([ "document_id" => $nuip->document_id, "country_id" => $country_id ]);
        $pap = Document::select('document_id')->where('code','PAP')->first();
        Country_document::create([ "document_id" => $pap->document_id, "country_id" => $country_id ]);
        $ti = Document::select('document_id')->where('code','TI')->first();
        Country_document::create([ "document_id" => $ti->document_id, "country_id" => $country_id ]);
        $nif = Document::select('document_id')->where('code','NIF')->first();
        Country_document::create([ "document_id" => $nif->document_id, "country_id" => $country_id ]);
        
        // España
        $country_id = Country::where('name','España')->first()->country_id;

        // Documentos de España
        $nie = Document::select('document_id')->where('code','NIE')->first();
        Country_document::create([ "document_id" => $nie->document_id, "country_id" => $country_id ]);
        $dni = Document::select('document_id')->where('code','DNI')->first();
        Country_document::create([ "document_id" => $dni->document_id, "country_id" => $country_id ]);
        $dnie = Document::select('document_id')->where('code','DNIe')->first();
        Country_document::create([ "document_id" => $dnie->document_id, "country_id" => $country_id ]);

    }
}
