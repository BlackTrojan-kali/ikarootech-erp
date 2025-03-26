<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Vracstock extends Model
{
    use HasFactory;
    public function citerne()
    {
        return $this->BelongsTo(Citerne::class, "citerne_id");
    }
}
