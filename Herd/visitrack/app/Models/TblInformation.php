<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\BelongsToRelationship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// namespace\class name
use App\Enums\SexEnum;
use App\Enums\RoleEnum;

class TblInformation extends Model
{

    //Foreign key constraints
    public function user_address(): BelongsTo{
        return $this->belongsTo(TblAddress::class, 'address');
    }

    public function credential(){
        return $this->hasOne(TblCredential::class, 'user_id', 'user_id');
    }

    public $timestamps = false; //Disables timestamps

    //Database Configuration
    protected $table = 'tbl_information';
    protected $primaryKey = 'user_id';

    //Columns that needs to be update
    protected $fillable = [
        'last_name', 
        'first_name', 
        'middle_name',
        'sex',
        'birthdate',
        'address',
        'credentials',
        'role'
    ];

    //Data Type Casting
    protected $casts = [
      'sex' => SexEnum:: class, //Custom sex class
      'birthdate' => 'date',
      'is_verified' => 'boolean',
      'role'=> RoleEnum:: class //Custom role class
    ];

    //Function to get the full name of a user
    public function getFullName(){
        return "{$this->last_name} {$this->first_name} {$this->middle_name}";
    }
}
