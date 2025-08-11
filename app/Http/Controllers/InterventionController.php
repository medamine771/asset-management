<?php

namespace App\Http\Controllers;

use App\Models\Intervention;
use App\Models\Equipement;
use App\Models\User;  // N’oublie pas d’importer User
use Illuminate\Http\Request;

class InterventionController extends Controller
{
    public function index()
    {
        // Charge aussi la relation technicien
        $interventions = Intervention::with(['equipement', 'technicien'])->get();
        return view('interventions.index', compact('interventions'));
    }

    public function create()
    {
        $equipements = Equipement::all();
        // Récupère les techniciens uniquement
        $techniciens = User::where('role', 'technicien')->get();
        return view('interventions.create', compact('equipements', 'techniciens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'equipement_id' => 'required|exists:equipements,id',
            'technicien_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
            'date_intervention' => 'required|date',
        ]);

        Intervention::create($request->all());

        return redirect()->route('interventions.index')->with('success', 'Intervention ajoutée avec succès.');
    }

    public function edit(Intervention $intervention)
    {
        $equipements = Equipement::all();
        $techniciens = User::where('role', 'technicien')->get();
        return view('interventions.edit', compact('intervention', 'equipements', 'techniciens'));
    }

    public function update(Request $request, Intervention $intervention)
    {
        $request->validate([
            'equipement_id' => 'required|exists:equipements,id',
            'technicien_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
            'date_intervention' => 'required|date',
        ]);

        $intervention->update($request->all());

        return redirect()->route('interventions.index')->with('success', 'Intervention mise à jour avec succès.');
    }

    public function destroy(Intervention $intervention)
    {
        $intervention->delete();
        return redirect()->route('interventions.index')->with('success', 'Intervention supprimée avec succès.');
    }
}
