@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier un Actif Numérique</h1>

    <form action="{{ route('actifs-numeriques.update', $actifs_numerique->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control" 
                   value="{{ old('nom', $actifs_numerique->nom) }}" required>
        </div>

        <div class="mb-3">
            <label>Type</label>
            <select name="type" class="form-control" required>
                <option value="logiciel" {{ $actifs_numerique->type == 'logiciel' ? 'selected' : '' }}>Logiciel</option>
                <option value="licence" {{ $actifs_numerique->type == 'licence' ? 'selected' : '' }}>Licence</option>
                <option value="abonnement" {{ $actifs_numerique->type == 'abonnement' ? 'selected' : '' }}>Abonnement</option>
                <option value="compte" {{ $actifs_numerique->type == 'compte' ? 'selected' : '' }}>Compte</option>
                <option value="certificat" {{ $actifs_numerique->type == 'certificat' ? 'selected' : '' }}>Certificat</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Fournisseur</label>
            <input type="text" name="fournisseur" class="form-control" 
                   value="{{ old('fournisseur', $actifs_numerique->fournisseur) }}">
        </div>

        <div class="mb-3">
            <label>Clé de licence / Identifiant</label>
            <input type="text" name="cle_licence" class="form-control" 
                   value="{{ old('cle_licence', $actifs_numerique->cle_licence) }}">
        </div>

        <div class="mb-3">
            <label>Date acquisition</label>
            <input type="date" name="date_acquisition" class="form-control" 
                   value="{{ old('date_acquisition', $actifs_numerique->date_acquisition) }}">
        </div>

        <div class="mb-3">
            <label>Date expiration</label>
            <input type="date" name="date_expiration" class="form-control" 
                   value="{{ old('date_expiration', $actifs_numerique->date_expiration) }}">
        </div>

        <div class="mb-3">
            <label>Coût</label>
            <input type="number" step="0.01" name="cout" class="form-control" 
                   value="{{ old('cout', $actifs_numerique->cout) }}">
        </div>

        <div class="mb-3">
            <label>Responsable</label>
            <select name="responsable_id" class="form-control">
                <option value="">-- Aucun --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" 
                        {{ $actifs_numerique->responsable_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Équipement</label>
            <select name="equipement_id" class="form-control">
                <option value="">-- Aucun --</option>
                @foreach($equipements as $eq)
                    <option value="{{ $eq->id }}" 
                        {{ $actifs_numerique->equipement_id == $eq->id ? 'selected' : '' }}>
                        {{ $eq->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>État</label>
            <select name="etat" class="form-control">
                <option value="actif" {{ $actifs_numerique->etat == 'actif' ? 'selected' : '' }}>Actif</option>
                <option value="expiré" {{ $actifs_numerique->etat == 'expiré' ? 'selected' : '' }}>Expiré</option>
                <option value="suspendu" {{ $actifs_numerique->etat == 'suspendu' ? 'selected' : '' }}>Suspendu</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Mettre à jour</button>
        <a href="{{ route('actifs-numeriques.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
