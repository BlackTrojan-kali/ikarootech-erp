<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory;
    
    public function fromStock(){
        return $this->belongsTo(Stock::class,"stock_id");
    }
    public function fromArticle(){
        return $this->belongsTo(Article::class,"article_id");
    }
}