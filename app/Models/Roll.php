<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roll extends Model
{
    use HasFactory;

    protected $table = "rolls";
    protected $primaryKey = 'roll_id';

    protected $fillable = [
        'name',
        'permissions',
    ];

    public $timestamps = true;
}
