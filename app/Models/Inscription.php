<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    protected $table = "inscriptions";
    protected $primaryKey = 'inscription_id';

    protected $fillable = [
        'player_id',
        'game_id',
        'cartons_ids',
        'status',
    ];

    public $timestamps = true;
}
