<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    use HasFactory;

    protected $table = "series";
    protected $primaryKey = 'serie_id';

    protected $fillable = [
        'letter_id',
        'number_id',
    ];

    public $timestamps = true;
}
