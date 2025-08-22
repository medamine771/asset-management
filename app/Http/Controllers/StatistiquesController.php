<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Intervention;
use App\Models\Equipement;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StatistiquesController extends Controller
{
    public function index()
    {
        // 1. Temps moyen de réparation (en heures)
        $avgRepairTime = Intervention::whereNotNull('date_intervention')
            ->select(DB::raw('AVG(TIMESTAMPDIFF(HOUR, created_at, date_intervention)) as avg_time'))
            ->value('avg_time');

        // 2. Nombre d’interventions par technicien
        $interventionsPerTechnician = User::where('role', 'technicien')
            ->withCount('interventions')
            ->orderByDesc('interventions_count')
            ->get();

        // 3. Équipements les plus souvent en panne
        $mostBrokenEquipments = Equipement::select('equipements.nom', DB::raw('COUNT(interventions.id) as panne_count'))
            ->join('interventions', 'equipements.id', '=', 'interventions.equipement_id')
            ->groupBy('equipements.id', 'equipements.nom')
            ->orderByDesc('panne_count')
            ->take(5)
            ->get();

        return view('statistiques.index', compact('avgRepairTime', 'interventionsPerTechnician', 'mostBrokenEquipments'));
    }
}
