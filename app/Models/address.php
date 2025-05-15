<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
    protected $primaryKey = 'address_id';
    public $incrementing = true;
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    protected $fillable = [
        'user_id',
        'street_no',
        'street_name',
        'barangay',
        'district',
        'city',
    ];
}
