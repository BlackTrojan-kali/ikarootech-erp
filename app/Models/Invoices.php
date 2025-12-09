<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    use HasFactory;
    protected $fillables= [
        
            "id_client",
            "total_price",
            "commercial",
            "region",
            "currency",
            "type",
            "id_versement",
           
    ];
    public function client()
    {
        return $this->belongsTo(Client::class, "id_client", "id");
    }
    public function scopeSansVersement($query){
        return $query->whereDoesntHave("versement");
    }
    public function versement(){
        return $this->belongsToMany(Versement::class);
        }
} 