<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TblQrCode extends Model
{

    //Foreign key constraints
    public function information_constraint(): BelongsTo{
        return $this->belongsTo(TblInformation::class, 'user_id', 'user_id');
    }

    //Casting integer
    protected $casts = [
        'qr_id' => 'integer', //Primary Key
        'user_id' => 'integer' //Foreign key
    ];

    //Define the table name
    protected $table = 'tbl_qr_code';

    //Define the primary key
    protected $primaryKey = 'qr_id';

    protected $fillable = [
        'user_id',
        'qr_text',
        'qr_picture'
    ];
}
