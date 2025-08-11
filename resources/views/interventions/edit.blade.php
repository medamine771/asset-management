@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier l'intervention</h1>
    <form action="{{ route('interventions.update', $intervention) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Équipement</label>
            <select name="equipement_id" class="form-select" required>
                <option value="">-- Sélectionner --</option>
                @foreach($equipements as $equipement)
                    <option value="{{ $equipement->id }}" {{ $intervention->equipement_id == $equipement->id ? 'selected' : '' }}>
                        {{ $equipement->nom }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $intervention->description }}</textarea>
        </div>
        <div class="mb-3">
            <label>Date d'intervention</label>
            <input type="date" name="date_intervention" class="form-control" value="{{ $intervention->date_intervention?->format('Y-m-d') }}" required>
        </div>
        <button class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('interventions.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
