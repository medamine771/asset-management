@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0" style="color: #004d40; font-weight: 700; letter-spacing: 1.2px;">
            Emplacements
        </h1>
        <a href="{{ route('emplacements.create') }}" class="btn btn-ocp">
            <i class="bi bi-plus-circle me-1"></i> Ajouter
        </a>
    </div>

    <!-- Grille de cartes -->
    @if($emplacements->isEmpty())
        <div class="alert alert-warning text-center">
            <i class="bi bi-exclamation-triangle me-1"></i> Aucun emplacement trouvé.
        </div>
    @else
        <div class="row g-3">
            @foreach($emplacements as $emplacement)
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title text-ocp">{{ $emplacement->nom }}</h5>
                        <div class="mt-3 d-flex justify-content-between">
                            <a href="{{ route('emplacements.edit', $emplacement) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square me-1"></i> Modifier
                            </a>
                            <form action="{{ route('emplacements.destroy', $emplacement) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash me-1"></i> Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

    <!-- Bouton retour -->
    <div class="mt-4">
        <a href="{{ route('dashboard') }}" class="btn btn-ocp-outline">
            <i class="bi bi-arrow-left me-1"></i> Retour au tableau de bord
        </a>
    </div>
</div>

<!-- Styles spécifiques -->
<style>
    .text-ocp { color: #004d40; font-weight: 600; }
    .btn-ocp {
        background-color: #004d40;
        color: #fff;
        border: none;
    }
    .btn-ocp:hover {
        background-color: #00695c;
        color: #fff;
    }
    .btn-ocp-outline {
        border: 1px solid #004d40;
        color: #004d40;
        background: transparent;
    }
    .btn-ocp-outline:hover {
        background-color: #004d40;
        color: #fff;
    }
    .card {
        border-radius: 0.5rem;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    }
</style>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
