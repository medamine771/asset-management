<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipement extends Model
{
    protected $fillable = ['nom', 'description', 'categorie_id', 'emplacement_id', 'etat', 'date_acquisition'];
    protected $casts = [
        'date_acquisition' => 'datetime',
    ];
    
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function emplacement()
    {
        return $this->belongsTo(Emplacement::class);
    }

    public function interventions()
    {
        return $this->hasMany(Intervention::class);
    }

    
}
