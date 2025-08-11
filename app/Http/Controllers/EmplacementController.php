<?php

namespace App\Http\Controllers;

use App\Models\Emplacement;
use Illuminate\Http\Request;

class EmplacementController extends Controller
{
    public function index()
    {
        $emplacements = Emplacement::all();
        return view('emplacements.index', compact('emplacements'));
    }

    public function create()
    {
        return view('emplacements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        Emplacement::create([
            'nom' => $request->nom,
        ]);

        return redirect()->route('emplacements.index')->with('success', 'Emplacement ajouté avec succès.');
    }

    public function edit(Emplacement $emplacement)
    {
        return view('emplacements.edit', compact('emplacement'));
    }

    public function update(Request $request, Emplacement $emplacement)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $emplacement->update([
            'nom' => $request->nom,
        ]);

        return redirect()->route('emplacements.index')->with('success', 'Emplacement mis à jour avec succès.');
    }

    public function destroy(Emplacement $emplacement)
    {
        $emplacement->delete();
        return redirect()->route('emplacements.index')->with('success', 'Emplacement supprimé avec succès.');
    }
}
