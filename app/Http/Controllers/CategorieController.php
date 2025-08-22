<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        Categorie::create([
            'nom' => $request->nom,
        ]);

        return redirect()->route('categories.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => 'Ajouté!',
                'text' => 'La catégorie a été ajoutée avec succès.'
            ]);
    }

    public function edit($id)
    {
        $categorie = Categorie::findOrFail($id);
        return view('categories.edit', compact('categorie'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $categorie = Categorie::findOrFail($id);
        $categorie->update([
            'nom' => $request->nom
        ]);

        return redirect()->route('categories.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => 'Modifié!',
                'text' => 'La catégorie a été mise à jour avec succès.'
            ]);
    }

    public function destroy($id)
    {
        $categorie = Categorie::findOrFail($id);
        $categorie->delete();

        return redirect()->route('categories.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => 'Supprimé!',
                'text' => 'La catégorie a été supprimée avec succès.'
            ]);
    }
}
