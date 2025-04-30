<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TblAddress extends Model
{
    //Define relationship and foreign key constraint
    public function user(): BelongsTo
    {
        return $this->belongsTo(TblInformation::class, 'user_id');
        // return $this->belongsTo(TblInformation::class, 'user_id');
    }

    //Casting integer
    protected $casts = [
        'address_id' => 'integer', //Primary Key
        'user_id' => 'integer' //Foreign key
    ];

    protected $table = 'tbl_address';
    protected $primaryKey = 'address_id';

    protected $fillable = [
        'user_id', 
        'street_no',
        'street_name',
        'barangay',
        'city'
    ];

    // Consider adding for nullable fields
    protected $attributes = [
        'district' => null // Explicitly handle null
    ];
}
