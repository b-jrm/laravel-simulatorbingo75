<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = "locations";
    protected $primaryKey = 'location_id';

    protected $fillable = [
        'name',
        'city_id',
    ];

    public $timestamps = true;
}
