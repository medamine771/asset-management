@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter une intervention</h1>
    <form action="{{ route('interventions.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Équipement</label>
            <select name="equipement_id" class="form-select" required>
                <option value="">-- Sélectionner --</option>
                @foreach($equipements as $equipement)
                    <option value="{{ $equipement->id }}">{{ $equipement->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Technicien</label>
            <select name="technicien_id" class="form-select" required>
                <option value="">-- Sélectionner --</option>
                @foreach($techniciens as $technicien)
                    <option value="{{ $technicien->id }}">{{ $technicien->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Date d'intervention</label>
            <input type="date" name="date_intervention" class="form-control" required>
        </div>

        <button class="btn btn-success">Ajouter</button>
        <a href="{{ route('interventions.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
