@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des emplacements</h1>
    <a href="{{ route('emplacements.create') }}" class="btn btn-primary mb-3">Ajouter un emplacement</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($emplacements as $emplacement)
                <tr>
                    <td>{{ $emplacement->nom }}</td>
                    <td>
                        <a href="{{ route('emplacements.edit', $emplacement) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('emplacements.destroy', $emplacement) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="2">Aucun emplacement trouvé.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
