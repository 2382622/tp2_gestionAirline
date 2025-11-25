<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Vol extends Model
{
    use HasFactory;

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
        'photo',
    ];
    protected $appends = ['photo_url'];

    public function avion()
    {
        return $this->belongsTo(Avion::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'vol_id', 'id');
    }

    public function getPhotoUrlAttribute(): ?string
    {
        if (!$this->photo) {
            return null;
        }

        return Storage::disk('public')->url($this->photo);
    }
}
