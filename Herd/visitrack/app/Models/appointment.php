<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointment';
    protected $primaryKey = 'appointment_id';
    
    protected $fillable = [
        'user_id',
        'visit_id',
        'visit_date',
        'visit_time',
        'approval',
        'qr_code',
        'status',
        'approved_at'
    ];

    public function qrCode()
    {
        return $this->hasOne(QrCode::class, 'appointment_id');
    }

    public function user()
    {
        return $this->belongsTo(Information::class, 'user_id');
    }

    public function is_approved($excludeStatuses = [])
    {
        return $this->status === 'approved' && !in_array($this->status, $excludeStatuses);
    }
}