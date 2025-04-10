<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientprice extends Model
{
    use HasFactory;
    public function client()
    {
        return $this->belongsTo(Clientcat::class, "id_cat", "id");
    }
    public function article()
    {
        return $this->belongsTo(Article::class, "id_article", "id");
    }
}
