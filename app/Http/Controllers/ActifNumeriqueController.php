<?php

namespace App\Http\Controllers;

use App\Models\ActifNumerique;
use App\Models\User;
use App\Models\Equipement;
use Illuminate\Http\Request;

class ActifNumeriqueController extends Controller
{
    public function index()
    {
        $actifs = ActifNumerique::with(['responsable','equipement'])->paginate(10);
        return view('actifs_numeriques.index', compact('actifs'));
    }

    public function create()
    {
        $users = User::all();
        $equipements = Equipement::all();
        return view('actifs_numeriques.create', compact('users','equipements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'type' => 'required',
            'responsable_id' => 'nullable|exists:users,id',
            'equipement_id' => 'nullable|exists:equipements,id',
        ]);

        ActifNumerique::create($request->all());
        return redirect()->route('actifs-numeriques.index')->with('success', 'Actif ajouté avec succès');
    }

    public function edit(ActifNumerique $actifs_numerique)
    {
        $users = User::all();
        $equipements = Equipement::all();
        return view('actifs_numeriques.edit', compact('actifs_numerique','users','equipements'));
    }

    public function update(Request $request, ActifNumerique $actifs_numerique)
    {
        $request->validate([
            'nom' => 'required',
            'type' => 'required',
        ]);

        $actifs_numerique->update($request->all());
        return redirect()->route('actifs-numeriques.index')->with('success', 'Actif mis à jour');
    }

    public function destroy(ActifNumerique $actifs_numerique)
    {
        $actifs_numerique->delete();
        return redirect()->route('actifs-numeriques.index')->with('success', 'Actif supprimé');
    }
}
