<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receive extends Model
{
    use HasFactory;
    
    public function citerne(){
        return $this->belongsTo(Citerne::class,"id_citerne");
    }
}
