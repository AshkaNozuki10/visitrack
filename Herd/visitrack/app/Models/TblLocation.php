<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblLocation extends Model
{
    public function information(){
        return $this->belongsTo(TblInformation::class);
    }
    
}
