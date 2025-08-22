@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter un Actif Numérique</h1>

    <form action="{{ route('actifs-numeriques.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Type</label>
            <select name="type" class="form-control" required>
                <option value="logiciel">Logiciel</option>
                <option value="licence">Licence</option>
                <option value="abonnement">Abonnement</option>
                <option value="compte">Compte</option>
                <option value="certificat">Certificat</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Responsable</label>
            <select name="responsable_id" class="form-control">
                <option value="">-- Aucun --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>État</label>
            <select name="etat" class="form-control">
                <option value="actif">Actif</option>
                <option value="expiré">Expiré</option>
                <option value="suspendu">Suspendu</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
    </form>
</div>
@endsection
