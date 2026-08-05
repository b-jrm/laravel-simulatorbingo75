<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $table = "games";
    protected $primaryKey = 'game_id';

    protected $fillable = [
        'time_start',
        'max_players',
        'min_players',
        'price_bet',
        'price_win',
        'context_id',
    ];

    public $timestamps = true;
}
