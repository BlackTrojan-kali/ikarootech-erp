<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoicetrace extends Model
{
    use HasFactory;
 protected $fillable=[
              "id_invoice",
            "id_article",
            "qty",
            "unit_price",
            "region",
            "type",
 ];
    public function invoice()
    {
        return $this->belongsTo(Invoices::class, "id_invoice", "id");
    }
    public function article()
    {
        return $this->belongsTo(Article::class, "id_article", "id");
    }
}
