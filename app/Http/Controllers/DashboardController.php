<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Equipement;
use App\Models\Intervention;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\ActifNumerique;


class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {

            // Nombre total d’actifs numériques
$nombreActifsNumeriques = ActifNumerique::count();

// Actifs expirés
$actifsExpirés = ActifNumerique::where('etat', 'expiré')->count();

// Actifs qui expirent bientôt (dans 30 jours)
$actifsBientotExpirés = ActifNumerique::whereDate('date_expiration', '<', now()->addDays(30))
    ->where('etat', '!=', 'expiré')
    ->count();

// Répartition par type (logiciel, abonnement, certificat…)
$repartitionActifs = ActifNumerique::select('type', DB::raw('COUNT(*) as total'))
    ->groupBy('type')
    ->get();

            // Stats de base
            $nombreEquipements = Equipement::count();
            $nombreIntervention = Intervention::count();
            $nombreTechniciens = User::where('role', 'technicien')->count();
            
            // Nombre d'équipements en panne
            $nombreEquipementsEnPanne = Equipement::where('etat', 'en panne')->count();

            // Nombre d'interventions par technicien
            $interventionsParTechnicien = User::where('role', 'technicien')
                ->withCount('interventions')
                ->orderByDesc('interventions_count')
                ->get();

            // Équipements les plus souvent en panne (Top 5)
            $equipementsPannes = Equipement::select('equipements.nom', DB::raw('COUNT(interventions.id) as panne_count'))
                ->join('interventions', 'equipements.id', '=', 'interventions.equipement_id')
                ->groupBy('equipements.id', 'equipements.nom')
                ->orderByDesc('panne_count')
                ->take(5)
                ->get();

            // Interventions par mois pour Chart.js
            $stats = Intervention::select(
                        DB::raw('MONTH(created_at) as mois'),
                        DB::raw('COUNT(*) as total')
                    )
                    ->whereYear('created_at', date('Y'))
                    ->groupBy('mois')
                    ->orderBy('mois')
                    ->get();

            $mois = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
            $interventionsParMois = array_fill(0, 12, 0);

            foreach ($stats as $stat) {
                $interventionsParMois[$stat->mois - 1] = $stat->total;
            }

            return view('admin.dashboard', compact(
                'nombreEquipements', 
                'nombreIntervention', 
                'nombreTechniciens',
                'nombreEquipementsEnPanne',
                'interventionsParTechnicien',
                'equipementsPannes',
                'mois',
                'interventionsParMois',
                'nombreActifsNumeriques',
                'actifsExpirés',
                'actifsBientotExpirés',
                'repartitionActifs'
            ));
            
        }

        if ($user->role === 'technicien') {
            // Équipements liés aux interventions du technicien
            $equipements = Equipement::whereHas('interventions', function($query) use ($user) {
                $query->where('technicien_id', $user->id);
            })->with(['categorie', 'emplacement'])->get();
        
            // Équipements en panne associés au technicien connecté
            $equipementsEnPanne = Equipement::whereHas('interventions', function($query) use ($user) {
                $query->where('technicien_id', $user->id)
                      ->where('statut', 'en_attente');
            })->with(['categorie', 'emplacement'])->get();
        
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
        
            return view('tech.dashboard', compact('equipements', 'equipementsEnPanne', 'interventions'));
        }

        abort(403, 'Accès non autorisé');
    }
}
