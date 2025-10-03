<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vol extends Model
{
    use HasFactory;

    // Comme la clé primaire est un string (id du vol) donc pas de autoIncrememnt
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'date_depart',
        'date_arrive',
        'origine',
        'destination',
        'prix',
        'efface',
        'avion_id',
    ];

    // Relation : un vol appartient à un avion
    public function avion()
    {
        return $this->belongsTo(Avion::class);
    }
}
