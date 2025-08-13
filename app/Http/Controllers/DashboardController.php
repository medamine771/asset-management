<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Equipement;
use App\Models\Intervention;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // public function index()
    // {
    //     $user = Auth::user();

    //     if ($user->role === 'admin') {
    //         // Stats pour l'admin
    //         $nombreEquipements = Equipement::count();
    //         $nombreIntervention = Intervention::count();

    //         return view('dashboard', compact('nombreEquipements', 'nombreIntervention'));
    //     }

       
    // if ($user->role === 'technicien') {
    //     $equipementsEnPanne = Equipement::where('etat', 'en panne')->get();
    //     return view('tech.dashboard', compact('equipementsEnPanne'));
    // }

    //     // Si jamais un autre rôle existe plus tard
    //     abort(403, 'Accès non autorisé');
    // }
    public function index()
{
    $user = Auth::user();

    if ($user->role === 'admin') {
        // Stats pour l'admin
        $nombreEquipements = Equipement::count();
        $nombreIntervention = Intervention::count();
        $nombreTechniciens = User::where('role', 'technicien')->count();

        // Récupérer le nombre d'interventions par mois pour l'année en cours
        $stats = Intervention::select(
                    DB::raw('MONTH(created_at) as mois'),
                    DB::raw('COUNT(*) as total')
                )
                ->whereYear('created_at', date('Y'))
                ->groupBy('mois')
                ->orderBy('mois')
                ->get();

        // Tableau des noms de mois
        $mois = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
        // Initialiser un tableau avec 0 pour chaque mois
        $interventionsParMois = array_fill(0, 12, 0);

        // Remplir avec les données récupérées
        foreach ($stats as $stat) {
            $interventionsParMois[$stat->mois - 1] = $stat->total;
        }

        return view('admin.dashboard', compact(
            'nombreEquipements', 
            'nombreIntervention', 
            'nombreTechniciens',
            'mois',
            'interventionsParMois'
        ));
    }

    if ($user->role === 'technicien') {
        // Équipements en panne
        $equipementsEnPanne = Equipement::with(['categorie', 'emplacement'])
            ->where('etat', 'en panne')
            ->get();
        
        // Interventions filtrées
        $interventions = Intervention::with(['equipement'])
            ->where('technicien_id', $user->id)
            ->when(request('filter'), function($query, $filter) {
                if ($filter !== 'all') {
                    $query->where('statut', $filter);
                }
            })
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('tech.dashboard', compact('equipementsEnPanne', 'interventions'));
    }
    
    

    abort(403, 'Accès non autorisé');
}
}
