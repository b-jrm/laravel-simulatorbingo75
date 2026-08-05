<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carton_serie extends Model
{
    use HasFactory;

    protected $table = "cartons_series";
    protected $primaryKey = 'carton_serie_id';

    protected $fillable = [
        'x_axis',
        'y_axis',
        'carton_id',
        'serie_id',
    ];

    public $timestamps = true;
}
