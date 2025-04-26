<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TblVisit extends Model
{
    //Define relationships / foreign key constraints
    public function location(): BelongsTo{
        return $this->belongsTo(TblLocation::class, 'location');
    }

    public function user(): BelongsTo{
        return $this->belongsTo(TblInformation::class, 'user_id');
    }

    //Define table name
    protected $table = 'tbl_visit';

    //Define primary key
    protected $primaryKey = 'visit_id';

    //Fillable columns
    protected $fillable = [
        'visit_date',
        'entry_time',
        'exit_time',
        'location'
    ];
    
    //Casting data types
    protected $casts = [
        'visit_date' => 'date',
        'entry_time' => 'datetime:H:i:s',
        'exit_time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
