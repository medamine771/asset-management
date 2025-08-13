<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    protected $fillable = ['equipement_id', 'technicien_id', 'description', 'statut', 'date_intervention'];
    protected $casts = [
        'date_intervention' => 'datetime',
    ];
    public function equipement()
    {
        return $this->belongsTo(Equipement::class);
    }

    public function technicien()
    {
        return $this->belongsTo(User::class, 'technicien_id');
    }
    public function markAsComplete()
    {
        $this->update([
            'statut' => 'terminee',
            'date_intervention' => $this->date_intervention ?? now()
        ]);
    }
}
