<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    // Table liée
    protected $table = 'tickets';

    // Les colonnes que l'on peut remplir via create() ou update()
    protected $fillable = [
        'vol_id',
        'user_id',
        'quantite',
    ];

    /**
     * Relation : un ticket appartient à un vol
     * vol_id (tickets) → id (vols)
     */
    public function vol()
    {
        return $this->belongsTo(Vol::class, 'vol_id', 'id');
    }

    /**
     * Relation : un ticket appartient à un utilisateur
     * user_id (tickets) → id (users)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
