<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class TechnicienController extends Controller
{
    public function index()
    {
        $techniciens = User::where('role', 'technicien')->paginate(10);
        return view('techniciens.index', compact('techniciens'));
    }

    public function edit($id)
    {
        $technicien = User::findOrFail($id);
        return view('techniciens.edit', compact('technicien'));
    }

    public function update(Request $request, $id)
    {
        $technicien = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('users')->ignore($technicien->id),
            ],
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

    public function destroy($id)
    {
        $technicien = User::findOrFail($id);

        // Supprimer l'image associée si elle existe
        if ($technicien->image) {
            Storage::disk('public')->delete($technicien->image);
        }

        $technicien->delete();

        return redirect()->route('techniciens.index')->with('success', 'Technicien supprimé avec succès.');
    }
    public function show($id)
{
    $technicien = User::findOrFail($id);
    return view('techniciens.show', compact('technicien'));
}

}
