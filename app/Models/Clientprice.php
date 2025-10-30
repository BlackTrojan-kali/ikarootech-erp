<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientPrice extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'clientprices';
    
    /**
     * The attributes that are mass assignable.
     * Vous devez définir cette propriété pour permettre l'insertion/mise à jour.
     * @var array<int, string>
     */
    protected $fillable = [
        'id_cat',
        'id_article',
        'unite_price',
        'consigne_price',
        'region',
    ];

    /**
     * Get the client category (ClientCat) that owns the price.
     */
    public function client(): BelongsTo
    {
        // Renommé en clientCategory pour plus de clarté
        return $this->belongsTo(Clientcat::class, "id_cat", "id");
    }

    /**
     * Get the Article that the price is for.
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class, "id_article", "id");
    }
}