<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientcat extends Model
{
    use HasFactory;
    public function price(){
        return $this->hasMany(Clientprice::class,"id_cat","id");
    }
}
