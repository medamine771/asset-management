<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class TechnicienController extends Controller
{
    /**
     * Affiche la liste des techniciens
     */
    public function index()
    {
        $techniciens = User::where('role', 'technicien')->paginate(10);
        return view('techniciens.index', compact('techniciens'));
    }

    /**
     * Affiche le formulaire de création d’un technicien
     */
    public function create()
    {
        return view('techniciens.create');
    }

    /**
     * Enregistre un nouveau technicien
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'telephone'  => 'nullable|string|max:20|regex:/^[\+0-9\s\-]+$/',
            'password' => 'required|string|min:6',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public'); // stocker dans storage/app/public/images
        }
    
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
           
            'telephone' => $request->telephone,

            'password' => bcrypt($request->password),
            'role'     => 'technicien',
            'image'    => $path,
        ]);
    
        return redirect()->route('techniciens.index')->with('success', 'Technicien créé avec succès.');
    }
    

    /**
     * Affiche le formulaire d’édition d’un technicien
     */
    public function edit($id)
    {
        $technicien = User::findOrFail($id);
        return view('techniciens.edit', compact('technicien'));
    }

    /**
     * Met à jour un technicien
     */
    public function update(Request $request, $id)
    {
        $technicien = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('users')->ignore($technicien->id),
            ],
            'telephone' => 'nullable|string|max:20|regex:/^[\+0-9\s\-]+$/',
            'password' => 'nullable|string|min:6|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $technicien->name = $request->name;
        $technicien->email = $request->email;

        if ($request->filled('password')) {
            $technicien->password = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {
            if ($technicien->image) {
                Storage::disk('public')->delete($technicien->image);
            }
            $path = $request->file('image')->store('users', 'public');
            $technicien->image = $path;
        }

        $technicien->save();

        return redirect()->route('techniciens.index')->with('success', 'Technicien modifié avec succès.');
    }

    /**
     * Supprime un technicien
     */
    public function destroy($id)
    {
        $technicien = User::findOrFail($id);

        if ($technicien->image) {
            Storage::disk('public')->delete($technicien->image);
        }

        $technicien->delete();

        return redirect()->route('techniciens.index')->with('success', 'Technicien supprimé avec succès.');
    }

    /**
     * Affiche les détails d’un technicien
     */
    public function show($id)
    {
        $technicien = User::findOrFail($id);
        return view('techniciens.show', compact('technicien'));
    }
}
