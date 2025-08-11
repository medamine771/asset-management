<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emplacement extends Model
{
    protected $fillable = ['nom', 'description'];

    public function equipements()
    {
        return $this->hasMany(Equipement::class);
    }
}
