<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    protected $table = 'tbl_qr_codes';
    
    protected $fillable = [
        'user_id',
        'appointment_id',
        'qr_text',
        'qr_picture'
    ];

    public function appointment()
    {
        return $this->belongsTo(appointment::class, 'appointment_id');
    }

    public function user()
    {
        return $this->belongsTo(Information::class, 'user_id');
    }
}