<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Versement extends Model
{
    use HasFactory;
    
    public function scopeSansInvoiceSpec($query, $invoiceId)
    {
        return $query->whereDoesntHave('invoice', function ($query) use ($invoiceId) {
            $query->where('invoices.id', $invoiceId);
        });
    }
    public function scopeAvecInvoiceSpec($query, $invoiceId)
    {
        return $query->whereHas('invoice', function ($query) use ($invoiceId) {
            $query->where('invoices.id', $invoiceId);
        });
    }
    public function Invoice(){
        return $this->belongsToMany(Invoices::class);
        }
        public function client(){
            return $this->belongsTo(Client::class,"client_id");
        }
    
}
