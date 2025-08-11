@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter un emplacement</h1>
    <form action="{{ route('emplacements.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ old('nom') }}" required>
        </div>
        <button class="btn btn-success">Ajouter</button>
        <a href="{{ route('emplacements.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
