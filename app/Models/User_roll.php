<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_roll extends Model
{
    use HasFactory;

    protected $table = "users_rolls";
    protected $primaryKey = 'user_roll_id';

    protected $fillable = [
        'user_id',
        'roll_id',
    ];

    public $timestamps = true;
}
