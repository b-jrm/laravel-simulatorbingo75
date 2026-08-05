<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mode extends Model
{
    use HasFactory;

    protected $table = "modes";
    protected $primaryKey = 'mode_id';

    protected $fillable = [
        'name',
        'context_id',
    ];

    public $timestamps = true;
}
