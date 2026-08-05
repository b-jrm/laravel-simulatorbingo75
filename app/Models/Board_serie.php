<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board_serie extends Model
{
    use HasFactory;

    protected $table = "boards_series";
    protected $primaryKey = 'board_serie_id';

    protected $fillable = [
        'board_id',
        'serie_id',
    ];

    public $timestamps = true;
}
