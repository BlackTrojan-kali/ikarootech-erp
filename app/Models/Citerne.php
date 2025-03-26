<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Citerne extends Model
{
    use HasFactory;
    public function stock()
    {
        return $this->hasMany(Vracstock::class, "citerne_id")->where("region", Auth::user()->region);
    }
}