<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Article extends Model
{
    use HasFactory;
    public function hasStock()
    {
        return $this->hasMany(Stock::class, "article_id", "id")->where("region", Auth::user()->region)->where("category", Auth::user()->role);
    }
}
