<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinate extends Model
{
    use HasFactory;

    protected $table = "coordinates";
    protected $primaryKey = 'coordinate_id';

    protected $fillable = [
        'x',
        'y',
    ];

    public $timestamps = true;
}
