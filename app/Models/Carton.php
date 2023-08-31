<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carton extends Model
{
    use HasFactory;

    protected $table = "cartons";
    protected $primaryKey = 'carton_id';

    protected $fillable = [
        'wins',
        'lost',
        'context_id',
    ];

    public $timestamps = true;
}
