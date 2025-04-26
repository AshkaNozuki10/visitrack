<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblLogin extends Model
{
    public function information(){
        return $this->belongsTo(TblInformation::class, 'user_id', 'user_id');
    }
}
