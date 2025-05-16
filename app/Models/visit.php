<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $table = 'visit';
    protected $primaryKey = 'visit_id';
    public $timestamps = true;

    protected $fillable = [
        'visit_id',
        'user_id',
        'visit_date',
        'entry_time',
        'exit_time',
        'location'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    
    public function location(){
        return $this->belongsTo(Location::class, 'location', 'location_id');
    }
}
