@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détail de l'équipement : {{ $equipement->nom }}</h1>

    <ul class="list-group">
        <li class="list-group-item"><strong>Nom:</strong> {{ $equipement->nom }}</li>
        <li class="list-group-item"><strong>Catégorie:</strong> {{ $equipement->categorie->nom ?? '-' }}</li>
        <li class="list-group-item"><strong>Emplacement:</strong> {{ $equipement->emplacement->nom ?? '-' }}</li>
        <li class="list-group-item"><strong>État:</strong> {{ $equipement->etat }}</li>
        <li class="list-group-item"><strong>Date acquisition:</strong> {{ $equipement->date_acquisition?->format('d/m/Y') ?? '-' }}</li>
        <li class="list-group-item"><strong>Description:</strong> {{ $equipement->description ?? '-' }}</li>
    </ul>

    <a href="{{ route('equipements.index') }}" class="btn btn-secondary mt-3">Retour</a>
</div>
@endsection