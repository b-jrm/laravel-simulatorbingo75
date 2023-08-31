<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = "countries";
    protected $primaryKey = 'country_id';

    protected $fillable = [
        'name',
        'zip',
        'indicative',
        'language',
        'currency',
        'continent_id',
    ];

    public $timestamps = true;
}
