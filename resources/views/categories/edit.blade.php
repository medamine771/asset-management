@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier la catégorie</h1>
    <form action="{{ route('categories.update', $categorie) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ old('nom', $categorie->nom) }}" required>
        </div>
        <button class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
