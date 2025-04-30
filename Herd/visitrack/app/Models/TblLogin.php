<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblLogin extends Model
{
    public function information(){
        return $this->belongsTo(TblInformation::class, 'user_id', 'user_id');
    }

    //Define table name
    protected $table = 'tbl_credential';

    //Define primary key
    protected $primaryKey = 'credential_id';

    protected $fillable = [
        'visit_date' => 'date',
        'entry_time' => 'timestamp',
        'exit_time' => 'timestamp'
    ];
}
