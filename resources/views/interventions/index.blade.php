@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des interventions</h1>
    <a href="{{ route('interventions.create') }}" class="btn btn-primary mb-3">Ajouter une intervention</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Équipement</th>
                <th>Description</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($interventions as $intervention)
                <tr>
                    <td>{{ $intervention->equipement->nom ?? '-' }}</td>
                    <td>{{ $intervention->description }}</td>
                    <td>{{ $intervention->date_intervention?->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('interventions.edit', $intervention) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('interventions.destroy', $intervention) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">Aucune intervention trouvée.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
