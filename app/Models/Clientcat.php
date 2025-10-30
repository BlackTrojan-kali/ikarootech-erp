<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clientcat extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * La convention de nommage est 'client_cats', mais comme votre table est 'clientcats', 
     * il est plus sûr de la spécifier explicitement.
     *
     * @var string
     */
    protected $table = 'clientcats';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'reduction',
    ];

    /**
     * Get the specific prices associated with the client category.
     * Nous utilisons le pluriel 'clientPrices' car il peut y avoir plusieurs prix associés
     * (un par article et région, par exemple).
     */
    public function clientPrices(): HasMany
    {
        // Assurez-vous d'utiliser la bonne casse pour le modèle ClientPrice si vous l'avez créé
        return $this->hasMany(ClientPrice::class, 'id_cat', 'id');
    }

    /**
     * Get the clients who belong to this category.
     * Ceci est la relation inverse du modèle Client que vous avez créé.
     */
    public function clients(): HasMany
    {
        return $this->hasMany(Client::class, 'id_clientcat', 'id');
    }
}