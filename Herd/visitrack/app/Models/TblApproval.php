<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblApproval extends Model
{
    public function information(){
        return $this->belongsTo(TblInformation::class);
    }

    //Define table name
    protected $table = 'tbl_approval';

    //Define primary key
    protected $primaryKey = 'approval_id';

    protected $fillable = [
        'user_id',
        'status',
        'reason',
        'date',
        'time'  
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime'
    ];
}
