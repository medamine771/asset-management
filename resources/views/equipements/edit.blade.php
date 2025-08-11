@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier l'équipement : {{ $equipement->nom }}</h1>

    <form action="{{ route('equipements.update', $equipement) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom', $equipement->nom) }}" required>
            @error('nom')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="categorie_id" class="form-label">Catégorie</label>
            <select name="categorie_id" id="categorie_id" class="form-select">
                <option value="">-- Sélectionner --</option>
                @foreach($categories as $categorie)
                    <option value="{{ $categorie->id }}" {{ old('categorie_id', $equipement->categorie_id) == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->nom }}
                    </option>
                @endforeach
            </select>
            @error('categorie_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="emplacement_id" class="form-label">Emplacement</label>
            <select name="emplacement_id" id="emplacement_id" class="form-select">
                <option value="">-- Sélectionner --</option>
                @foreach($emplacements as $emplacement)
                    <option value="{{ $emplacement->id }}" {{ old('emplacement_id', $equipement->emplacement_id) == $emplacement->id ? 'selected' : '' }}>
                        {{ $emplacement->nom }}
                    </option>
                @endforeach
            </select>
            @error('emplacement_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="etat" class="form-label">État</label>
            <input type="text" name="etat" id="etat" class="form-control" value="{{ old('etat', $equipement->etat) }}" required>
            @error('etat')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="date_acquisition" class="form-label">Date d'acquisition</label>
            <input type="date" name="date_acquisition" id="date_acquisition" class="form-control" value="{{ old('date_acquisition', $equipement->date_acquisition?->format('Y-m-d')) }}">
            @error('date_acquisition')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $equipement->description) }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image de l'équipement</label>
            @if($equipement->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $equipement->image) }}" alt="Image équipement" style="max-width: 150px; border-radius: 5px;">
                </div>
            @endif
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <button class="btn btn-primary" type="submit">Mettre à jour</button>
        <a href="{{ route('equipements.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
