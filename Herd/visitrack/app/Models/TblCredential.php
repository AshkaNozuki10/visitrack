<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblCredential extends Model
{
    public function information(){
        return $this->belongsTo(TblInformation::class);
    }

    //Define table name
    protected $table = 'tbl_credential';

    //Define primary key
    protected $primaryKey = 'credential_id';

    protected $fillable = [
        'username' => 'string',
        'password' => 'string'
    ];
}
