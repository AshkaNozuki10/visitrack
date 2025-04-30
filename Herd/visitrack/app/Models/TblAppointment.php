<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TblAppointment extends Model
{
    //Foreign key constraints
    public function constraint_user(): BelongsTo{
        return $this->belongsTo(TblInformation::class, 'user_id');
    }

    public function constraint_visit(): BelongsTo{
        return $this->belongsTo(TblVisit::class, 'visit_id');
    }
    
    public function check_approval(): BelongsTo{
        return $this->belongsTo(TblApproval::class, 'approval_id');
    }    

    public function qr_code(): BelongsTo{
        return $this->belongsTo(TblQrCode::class, 'qr_code');
    }
    
    //Define table name
    protected $table = 'tbl_appointment';

    //Define primary key
    protected $primaryKey = 'appointment_id';

    protected $casts = [
        'visit_date' => 'date',
        'visit_time' => 'datetime:H:i:s',
        'created_date' => 'date',
        'created_time' => 'datetime'

    ];
    protected $fillable = [
        'user_id',
        'visit_id',
        'visit_date',
        'visit_time',
        'approval',
        'qr_code'
    ];
    
}
