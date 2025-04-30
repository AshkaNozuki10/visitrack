<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblCredential extends Model
{
    public function user(){
        return $this->belongsTo(TblInformation::class, 'user_id'. 'user_id');
    }

    //Define table name
    protected $table = 'tbl_credential';

    //Define primary key
    protected $primaryKey = 'credential_id';

    protected $fillable = [
        'username' => 'string',
        'password' => 'string'
    ];
    
    public $timestamps = false; //No timestamp needed
}
