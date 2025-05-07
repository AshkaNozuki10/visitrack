<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Credential extends Authenticatable
{
    protected $table = 'credential';
    protected $primaryKey = 'credential_id';
    public $incrementing = true;
    public $timestamps = true;

    public function information(){
        return $this->belongsTo(Information::class, 'user_id', 'user_id')->withDefault([
            'role' => 'visitor' // Default role if relationship fails
        ]);
    }

    protected $fillable = [
        'user_id',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];
}
