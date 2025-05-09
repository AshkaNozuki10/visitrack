<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Credential extends Authenticatable
{
    protected $table = 'credential';
    protected $primaryKey = 'credential_id';
    public $incrementing = true;
    public $timestamps = true;

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'user_id')->withDefault([
            'role' => 'visitor'
        ]);
    }

    protected $fillable = [
        'user_id',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];
}
