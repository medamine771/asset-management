<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActifNumerique extends Model
{
    use HasFactory;

    protected $table = 'actifs_numeriques'; // 👈 corrige ici

    protected $fillable = [
        'nom', 'type', 'fournisseur', 'cle_licence',
        'date_acquisition', 'date_expiration', 'cout',
        'etat', 'responsable_id', 'equipement_id'
    ];

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function equipement()
    {
        return $this->belongsTo(Equipement::class, 'equipement_id');
    }
}
