<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Context extends Model
{
    use HasFactory;

    protected $table = "contexts";
    protected $primaryKey = 'context_id';

    protected $fillable = [
        'name',
        'rows',
        'columns',
        'is_with_letters',
    ];

    public $timestamps = true;
}
