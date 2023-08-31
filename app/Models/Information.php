<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

    protected $table = "informations";
    protected $primaryKey = 'information_id';

    protected $fillable = [
        'user_id',
        'nickname',
        'firstname',
        'lastname',
        'document_id',
        'numberdocument',
        'photo',
        'phone',
        'mobile',
        'address',
        'birthdate',
        'gender',
        'language',
        'location_id',
        'city_id',
    ];

    public $timestamps = true;
}
