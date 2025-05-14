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
        'type',
        'transaction_type',
        'purpose_of_visit',
        'department_type',
        'building',
        'appointment_date',
        'appointment_time',
        'approval',
        'qr_code',
        'approved_at'
    ];

    public function qrCode()
    {
        return $this->belongsTo(QrCode::class, 'qr_code', 'qr_id');
    }

    public function visit()
    {
        return $this->belongsTo(Visit::class, 'visit_id', 'visit_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function is_approved($excludeStatuses = [])
    {
        return $this->status === 'approved' && !in_array($this->status, $excludeStatuses);
    }
}