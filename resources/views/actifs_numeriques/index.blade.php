@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des Actifs Numériques</h1>
    <a href="{{ route('actifs-numeriques.create') }}" class="btn btn-primary mb-3">Ajouter un actif</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Type</th>
                <th>Fournisseur</th>
                <th>Responsable</th>
                <th>État</th>
                <th>Date expiration</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($actifs as $actif)
            <tr>
                <td>{{ $actif->nom }}</td>
                <td>{{ $actif->type }}</td>
                <td>{{ $actif->fournisseur }}</td>
                <td>{{ $actif->responsable?->name }}</td>
                <td>{{ $actif->etat }}</td>
                <td>
                    @if($actif->date_expiration && $actif->date_expiration < now())
                        <span class="badge bg-danger">Expiré</span>
                    @elseif($actif->date_expiration && $actif->date_expiration < now()->addDays(30))
                        <span class="badge bg-warning">Expire bientôt</span>
                    @else
                        <span class="badge bg-success">Actif</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('actifs-numeriques.edit', $actif) }}" class="btn btn-warning btn-sm">Modifier</a>
                    <form action="{{ route('actifs-numeriques.destroy', $actif) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $actifs->links() }}
</div>
@endsection
