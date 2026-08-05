<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submode_coordinate extends Model
{
    use HasFactory;

    protected $table = "submodes_coordinates";
    protected $primaryKey = 'submode_coordinate_id';

    protected $fillable = [
        'submode_id',
        'coordinate_id',
    ];

    public $timestamps = true;
}
