<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Credential extends Authenticatable
{
    protected $table = 'credential';
    protected $primaryKey = 'user_id';
    public $incrementing = true;
    public $keyType = 'int';
    public $timestamps = false;

    public function information(){
        return $this->belongsTo(information::class, 'user_id', 'user_id');
    }

    protected $fillable = [
        'username',
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];
}
