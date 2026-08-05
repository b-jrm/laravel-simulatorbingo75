<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country_document extends Model
{
    use HasFactory;

    protected $table = "countries_documents";
    protected $primaryKey = 'country_document_id';

    protected $fillable = [
        'document_id',
        'country_id',
    ];

    public $timestamps = true;
}
