<?php

namespace App\Http\Controllers;

use App\Models\Equipement;
use App\Models\Categorie;
use App\Models\Emplacement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Gestion upload image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('equipements', 'public');
            $validated['image'] = $path;
        }

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Si une nouvelle image est uploadée, supprimer l'ancienne
        if ($request->hasFile('image')) {
            if ($equipement->image && Storage::disk('public')->exists($equipement->image)) {
                Storage::disk('public')->delete($equipement->image);
            }
            $path = $request->file('image')->store('equipements', 'public');
            $validated['image'] = $path;
        }

        $equipement->update($validated);

        return redirect()->route('equipements.index')->with('success', 'Équipement mis à jour avec succès.');
    }

    public function destroy(Equipement $equipement)
    {
        // Supprimer l'image associée si existe
        if ($equipement->image && Storage::disk('public')->exists($equipement->image)) {
            Storage::disk('public')->delete($equipement->image);
        }

        $equipement->delete();

        return redirect()->route('equipements.index')->with('success', 'Équipement supprimé avec succès.');
    }

    public function equipementsEnPanne()
    {
        $equipementsPanne = Equipement::where('etat', 'en panne')->get();

        return view('equipements.panne', ['equipementsEnPanne' => $equipementsPanne]);
    }

    public function historique(Equipement $equipement)
    {
        $interventions = $equipement->interventions()
            ->orderByDesc('date_intervention')
            ->get();
    
        // ⚠️ Bien passer 'equipement' à la vue
        return view('equipements.historique', compact('equipement', 'interventions'));
    }
    public function updateEtat(Request $request, Equipement $equipement)
{
    $request->validate([
        'etat' => 'required|in:bon,en panne,maintenance',
    ]);

    $equipement->etat = $request->etat;
    $equipement->save();

    return redirect()->back()->with('success', 'État de l’équipement mis à jour avec succès !');
}


}
