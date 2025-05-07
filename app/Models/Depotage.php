<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Depotage extends Model
{
    //

    public function citerne_mobile(){
        return $this->belongsTo(Citerne::class,"id_citerne_mobile","id");
    }
    public function citerne_fixe(){
        return $this->belongsTo(Citerne::class,"id_citerne_fixe","id");
    }
}
