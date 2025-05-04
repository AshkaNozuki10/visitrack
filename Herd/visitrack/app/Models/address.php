<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
    protected $primaryKey = 'address_id';
    public $incrementing = true;
    public $keyType = 'int';
    public $timestamps = false;

    public function information()
    {
        return $this->belongsTo(information::class, 'user_id');
    }

    protected $fillable = [
        'street_no',
        'street_name',
        'barangay',
        'district',
        'city',
    ];
}
