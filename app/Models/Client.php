<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * * Il est crucial de définir ceci pour pouvoir créer ou mettre à jour 
     * des enregistrements en utilisant des méthodes comme `create()` ou `update()`.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'numero',
        'address',
        'region',
        'email',
        'registre_commerce',
        'numero_unique',
        'id_clientcat',
    ];

    /**
     * Get the client category (price category) that the client belongs to.
     * * Par convention Laravel, les méthodes de relation sont nommées en 'camelCase' 
     * et utilisent le singulier pour les relations belongsTo/hasOne (ex: 'clientCat').
     */
    public function clientCat(): BelongsTo
    {
        return $this->belongsTo(Clientcat::class, 'id_clientcat', 'id');
    }
}