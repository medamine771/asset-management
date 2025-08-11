@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4" style="color: #004d40; font-weight: 700; letter-spacing: 1.5px;">
        Équipements en panne
    </h1>

    <p class="mb-4" style="font-weight: 600;">
        Bienvenue {{ Auth::user()->name }}
    </p>

    <!-- Formulaire de recherche -->
    <form method="GET" action="{{ route('equipements.panne') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Recherche par nom, catégorie, emplacement, date..."
                value="{{ request('search') }}">
            <button class="btn btn-ocp" type="submit">Rechercher</button>
        </div>
    </form>

    @if($equipementsEnPanne->isEmpty())
        <div class="alert alert-success" role="alert" style="background-color: #dff0d8; color: #3c763d;">
            Aucun équipement en panne
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Emplacement</th>
                        <th>Date d'acquisition</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($equipementsEnPanne as $equipement)
                        <tr>
                            <td>{{ $equipement->nom }}</td>
                            <td>{{ $equipement->categorie->nom ?? '-' }}</td>
                            <td>{{ $equipement->emplacement->nom ?? '-' }}</td>
                            <td>{{ $equipement->date_acquisition?->format('d/m/Y') ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $equipementsEnPanne->withQueryString()->links() }}
    @endif
</div>

<style>
    .btn-ocp {
        background-color: #004d40;
        color: #ffca28;
        font-weight: 600;
        transition: background-color 0.3s ease;
    }
    .btn-ocp:hover {
        background-color: #00695c;
        color: white;
    }
</style>
@endsection
