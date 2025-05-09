<?php

namespace App\Models;

use App\Enums\RoleEnum;
use App\Enums\SexEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'user';
    protected $primaryKey = 'user_id';
    public $incrementing = true;
    public $timestamps = true;

    public function credential(){
        return $this->hasOne(Credential::class, 'user_id', 'user_id');
    }

    public function address(){
        return $this->hasOne(Address::class, 'user_id', 'user_id');
    }

    protected $fillable = [
        'user_id',
        'last_name',
        'first_name',
        'middle_name',
        'sex',
        'birthdate',
        'role',
    ];

    protected $casts = [
        'sex' => SexEnum::class,
    ];

    protected function role(): Attribute{
        return new Attribute(
            get: fn($value) => ["visitor", "admin"][$value],
        );
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isVisitor()
    {
        return $this->role === 'visitor';
    }
}
