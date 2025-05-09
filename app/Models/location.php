<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'location';
    protected $primaryKey = 'location_id';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    
    protected $fillable = [
        'user_id',
        'building_name',
        'latitude',
        'longitude',
    ];
}
