<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Credential extends Authenticatable
{
    use Notifiable;
    
    protected $table = 'credential';
    protected $primaryKey = 'user_id';
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
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // Override getAuthIdentifierName to use user_id
    public function getAuthIdentifierName()
    {
        return 'user_id';
    }

    // Override getAuthIdentifier to return the correct ID
    public function getAuthIdentifier()
    {
        return $this->user_id;
    }

    // Override getKey to return user_id
    public function getKey()
    {
        return $this->user_id;
    }

    // Override getKeyName to return user_id
    public function getKeyName()
    {
        return 'user_id';
    }

    // Override getAuthPassword to return the password
    public function getAuthPassword()
    {
        return $this->password;
    }

    // Override getRememberTokenName to use remember_token
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    // Override getRememberToken to return the token
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    // Override setRememberToken to set the token
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }
}
