<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class location extends Model
{
    protected $table = 'location';
    protected $primaryKey = 'location_id';
    
    protected $fillable = [
        'user_id',
        'building_name',
        'latitude',
        'longitude',
    ];
}
