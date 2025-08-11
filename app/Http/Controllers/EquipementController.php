<?php

namespace App\Http\Controllers;

use App\Models\Equipement;
use App\Models\Categorie;
use App\Models\Emplacement;
use Illuminate\Http\Request;

class EquipementController extends Controller
{
    public function index()
    {
        $equipements = Equipement::with(['categorie', 'emplacement'])->paginate(10);
        return view('equipements.index', compact('equipements'));
    }

    public function create()
    {
        $categories = Categorie::all();
        $emplacements = Emplacement::all();
        return view('equipements.create', compact('categories', 'emplacements'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'categorie_id' => 'nullable|exists:categories,id',
            'emplacement_id' => 'nullable|exists:emplacements,id',
            'etat' => 'required|string|max:50',
            'date_acquisition' => 'nullable|date',
        ]);

        Equipement::create($validated);

        return redirect()->route('equipements.index')->with('success', 'Équipement créé avec succès.');
    }

    public function show(Equipement $equipement)
    {
        return view('equipements.show', compact('equipement'));
    }

    public function edit(Equipement $equipement)
    {
        $categories = Categorie::all();
        $emplacements = Emplacement::all();
        return view('equipements.edit', compact('equipement', 'categories', 'emplacements'));
    }

    public function update(Request $request, Equipement $equipement)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'categorie_id' => 'nullable|exists:categories,id',
            'emplacement_id' => 'nullable|exists:emplacements,id',
            'etat' => 'required|string|max:50',
            'date_acquisition' => 'nullable|date',
        ]);

        $equipement->update($validated);

        return redirect()->route('equipements.index')->with('success', 'Équipement mis à jour avec succès.');
    }

    public function destroy(Equipement $equipement)
    {
        $equipement->delete();

        return redirect()->route('equipements.index')->with('success', 'Équipement supprimé avec succès.');
    }
    public function equipementsEnPanne()
{
    // Par exemple, état = 'en panne' ou autre valeur que tu utilises
    $equipementsPanne = Equipement::where('etat', 'en panne')->get();

    return view('equipements.panne', compact('equipementsPanne'));
}



}
