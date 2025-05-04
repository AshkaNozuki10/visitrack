<?php

namespace App\Models;

use App\Enums\RoleEnum;
use App\Enums\SexEnum;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $table = 'information';
    protected $primaryKey = 'user_id';
    public $incrementing = true;
    public $keyType = 'int';
    public $timestamps = false;

    public function credential(){
        return $this->hasOne(credential::class, 'user_id', 'user_id');
    }

    public function address(){
        return $this->hasOne(address::class, 'user_id', 'user_id');
    }

    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'sex',
        'birthdate',
        'role',
    ];


    /*
    kindly remove this temporarily
    protected $casts = [
        'sex' => SexEnum::class,
        'role' => RoleEnum::class,
    ];
    */
}
