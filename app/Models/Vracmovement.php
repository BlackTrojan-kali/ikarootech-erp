<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vracmovement extends Model
{
    use HasFactory;
    public function citerne(){
        return $this->belongsTo(Citerne::class,"citerne_id");
    }
    public function vrackStock(){
        return $this->belongsTo(Vracstock::class,"vrackstock_id");
    }
}
