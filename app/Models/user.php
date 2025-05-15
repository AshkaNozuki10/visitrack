<?php

namespace App\Models;

use App\Enums\RoleEnum;
use App\Enums\SexEnum;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'user_id';
    public $incrementing = true;
    public $timestamps = true;

    public function credential(){
        return $this->hasOne(credential::class, 'user_id', 'user_id');
    }

    public function address(){
        return $this->hasOne(address::class, 'user_id', 'user_id');
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
}
