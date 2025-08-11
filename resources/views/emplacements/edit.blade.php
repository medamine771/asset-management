@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier l'emplacement</h1>
    <form action="{{ route('emplacements.update', $emplacement) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ old('nom', $emplacement->nom) }}" required>
        </div>
        <button class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('emplacements.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
