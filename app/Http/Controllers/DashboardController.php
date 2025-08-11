<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Equipement;
use App\Models\Intervention;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Stats pour l'admin
            $nombreEquipements = Equipement::count();
            $nombreIntervention = Intervention::count();

            return view('dashboard', compact('nombreEquipements', 'nombreIntervention'));
        }

       
    if ($user->role === 'technicien') {
        $equipementsEnPanne = Equipement::where('etat', 'en panne')->get();
        return view('tech.dashboard', compact('equipementsEnPanne'));
    }

        // Si jamais un autre rôle existe plus tard
        abort(403, 'Accès non autorisé');
    }
}
