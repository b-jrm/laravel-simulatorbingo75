<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submode extends Model
{
    use HasFactory;

    protected $table = "submodes";
    protected $primaryKey = 'submode_id';

    protected $fillable = [
        'name',
        'mode_id',
    ];

    public $timestamps = true;
}
