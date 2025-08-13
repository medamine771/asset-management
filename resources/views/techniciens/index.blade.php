@extends('layouts.app')

@section('title', 'Liste des techniciens')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-success fw-bold" style="letter-spacing: 1.5px;">
            Liste des techniciens
        </h1>
        <a href="{{ route('techniciens.create') }}" 
           class="btn btn-success fw-semibold shadow-sm" 
           title="Créer un nouveau technicien">
            <i class="bi bi-person-plus-fill me-1"></i> Nouveau technicien
        </a>
    </div>

    @if($techniciens->isEmpty())
        <div class="alert alert-warning">
            Aucun technicien trouvé.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-ocp text-white" style="background-color: #004d40;">
                    <tr>
                        <th>Photo</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Telephone</th>
                        <th>Rôle</th>
                        <th style="width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($techniciens as $tech)
                        <tr>
                            <td>
                                @if($tech->image)
                                    <img src="{{ asset('storage/' . $tech->image) }}" 
                                         alt="Photo de {{ $tech->name }}" 
                                         class="rounded-circle" 
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('images/default-avatar.png') }}" 
                                         alt="Pas de photo" 
                                         class="rounded-circle" 
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                @endif
                            </td>
                            <td>{{ $tech->name }}</td>
                            <td>{{ $tech->email }}</td>
                            <td>{{ $tech->telephone }}</td>
                            <td>{{ ucfirst($tech->role) }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('techniciens.show', $tech->id) }}" 
                                       class="btn btn-info btn-sm" 
                                       title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('techniciens.edit', $tech->id) }}" 
                                       class="btn btn-warning btn-sm" 
                                       title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('techniciens.destroy', $tech->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Voulez-vous vraiment supprimer ce technicien ?');"
                                          style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" title="Supprimer" type="submit">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $techniciens->links() }}
        </div>
    @endif

    <div class="d-flex justify-content-center mt-4">
        <a href="{{ route('dashboard') }}" 
           class="btn btn-outline-dark ripple" 
           title="Retour au tableau de bord">
            <i class="bi bi-arrow-left fs-5"></i>
        </a>
    </div>
</div>

<style>
    .table-ocp th {
        border: none;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 1px;
    }
    tbody tr:hover {
        background-color: #e6f4f1;
        transition: background-color 0.3s ease;
    }
    .btn-sm {
        width: 36px;
        height: 36px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        border-radius: 6px;
    }
</style>
@endsection
